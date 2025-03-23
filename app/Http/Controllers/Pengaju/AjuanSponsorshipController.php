<?php

namespace App\Http\Controllers\Pengaju;

use App\Models\Pengaju\AjuanSponsorship;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Gumlet\ImageResize;
use Illuminate\Support\Facades\Storage;
use App\Mail\PengajuanCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AjuanSponsorshipController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Jika pengguna adalah pengaju, tampilkan hanya data miliknya
        if (in_array($user->role, ['pengaju'])) {
            $ajuan = AjuanSponsorship::where('id_pengaju', $user->id)
                ->where(function ($query) {
                    $query->where('is_banding', true) // Status banding
                        ->orWhere('is_review', true) // Status review
                        ->orWhere('is_approved', true)
                        ->orWhere(function ($query) {
                            // Status menunggu (semua boolean false)
                            $query->where('is_banding', false)
                                ->where('is_review', false)
                                ->where('is_approved', false)
                                ->where('is_rejected', false)
                                ->where('is_aktif', false)
                                ->where('is_done', false);
                        });
                })
                ->get();
        }

        return view('pengaju.ajuan.index', compact('ajuan'), ['title' => 'Ajuan Saya']);
    }

    public function create()
    {
        return view('pengaju.ajuan.create', ['title' => 'Buat Ajuan']);
    }

    public function store(Request $request)
    {
        Log::info('Incoming request data for Ajuan Sponsorship:', $request->all());
        
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'event_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:event_date',
            'location' => 'required|string|max:255',
            'organizer_name' => 'required|string|max:255',
            'pic_name' => 'required|string|max:255',
            'pic_email' => 'required|email|max:255', // Tambahan email PIC
            'estimated_participants' => 'required|integer|min:1', // Tambahan estimasi partisipan
            'phone_number' => 'required|string|regex:/^[0-9]{10,15}$/',
            'proposal' => 'nullable|file|mimes:pdf,docx|max:2048',
        ], [
            'phone_number.regex' => 'Phone number must be 10-15 digits',
            'event_date.after_or_equal' => 'Event date cannot be in the past',
            'end_date.after_or_equal' => 'End date must be after or equal to event date',
            'pic_email.email' => 'Please enter a valid email address',
            'estimated_participants.min' => 'Participants must be at least 1'
        ]);
    
        if ($validator->fails()) {
            Log::error('Validation errors for Ajuan Sponsorship:', $validator->errors()->toArray());
            return back()->withErrors($validator)->withInput();
        }
    
        $validated = $validator->validated();
        // Menyimpan file proposal jika ada
        if ($request->hasFile('proposal')) {
            $proposalPath = $request->file('proposal')->store('proposals', 'public');
        }

        // Menyimpan data ke database
        $ajuanSponsorship = new AjuanSponsorship();
        $ajuanSponsorship->event_name = $request->event_name;
        $ajuanSponsorship->description = $request->description;
        $ajuanSponsorship->event_date = $request->event_date;
        $ajuanSponsorship->end_date = $request->end_date;
        $ajuanSponsorship->location = $request->location;
        $ajuanSponsorship->organizer_name = $request->organizer_name;
        $ajuanSponsorship->pic_name = $request->pic_name;
        $ajuanSponsorship->pic_email = $request->pic_email; // Save pic_email
        $ajuanSponsorship->estimated_participants = $request->estimated_participants; // Save estimated_participants
        $ajuanSponsorship->proposal = $proposalPath; // Menyimpan path file proposal
        $ajuanSponsorship->phone_number = $request->phone_number;
        $ajuanSponsorship->proposal = $proposalPath; // Menyimpan path file proposal
        $ajuanSponsorship->id_pengaju = auth()->user()->id;
        $ajuanSponsorship->save();
        Mail::to(auth()->user()->email)->send(new PengajuanCreated($ajuanSponsorship));

        return redirect()->route('ajuan.index')->with('success', 'Ajuan Sponsorship berhasil ditambahkan');
    }

    // Menampilkan detail ajuan
    public function show($id)
    {
        $ajuan = AjuanSponsorship::findOrFail($id);
        return view('pengaju.ajuan.show', compact('ajuan'), ['title' => 'Detail']);
    }

    //update status ajuan
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:diterima,ditolak,review,banding',
            'alasan' => [
                'nullable',
                'string',
                'max:500',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->status === 'ditolak' && empty($value)) {
                        $fail('Reason is required when rejecting an application');
                    }
                }
            ],
        ], [
            'status.in' => 'Invalid status value',
            'alasan.max' => 'Reason cannot exceed 500 characters'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Cari pengajuan berdasarkan ID
        $pengajuan = AjuanSponsorship::findOrFail($id);

        // Reset all statuses
        $statusFields = ['is_approved', 'is_rejected', 'is_review', 'is_banding'];
        foreach ($statusFields as $field) {
            $pengajuan->$field = false;
        }

        // Perbarui status sesuai input
        if ($request->status === 'diterima') {
            $pengajuan->is_approved = true;
        } elseif ($request->status === 'ditolak') {
            $pengajuan->is_rejected = true;
        } elseif ($request->status === 'review') {
            $pengajuan->is_review = true;
        } elseif ($request->status === 'banding') {
            $pengajuan->is_banding = true;
        }

        // Simpan alasan banding jika status adalah banding
        $pengajuan->alasan_banding = $request->alasan;

        // Save changes with transaction
        DB::transaction(function() use ($pengajuan) {
            $pengajuan->save();
        });

        // Log status update
        Log::info('Status updated for application ID: ' . $id, [
            'status' => $request->status,
            'updated_by' => auth()->user()->id
        ]);

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui!');
    }

    //ttd
    public function storeSignature(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'signature' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^data:image\/(png|jpeg);base64,/', $value)) {
                        $fail('Invalid signature format. Must be a base64 encoded PNG or JPEG image.');
                    }
                }
            ],
        ], [
            'signature.required' => 'Signature is required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Ambil data tanda tangan dalam bentuk base64
        $signatureData = $request->input('signature'); // base64 tanda tangan

        // Tentukan batas ukuran maksimal tanda tangan (misalnya 500 KB)
        $maxSize = 500000; // 500 KB
        $signatureSize = strlen(rtrim($signatureData, '='));

        // Jika ukuran tanda tangan lebih besar dari batas, beri error
        if ($signatureSize > $maxSize) {
            return back()->withErrors(['signature' => 'Tanda tangan terlalu besar.']);
        }

        $ajuan = AjuanSponsorship::findOrFail($id);

        // Decode base64 signature menjadi gambar
        $signatureImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureData));

        // Simpan gambar sementara di server
        $tempImagePath = storage_path('app/public/temp_signature.png');
        file_put_contents($tempImagePath, $signatureImage);

        // Menggunakan ImageResize untuk resize dan kompresi gambar
        $image = new ImageResize($tempImagePath);

        // Resize gambar dan kompresi kualitas menjadi 75%
        $image->resizeToWidth(300); // Mengubah lebar gambar menjadi 300px, mempertahankan aspek rasio
        $image->save($tempImagePath, IMAGETYPE_PNG, 75); // Simpan dengan kualitas 75%

        // Path untuk menyimpan gambar tanda tangan
        $signatureFileName = 'signature_' . $ajuan->id . '_' . time() . '.png';
        $signaturePath = 'signatures/' . $signatureFileName;

        // Pastikan direktori untuk signature ada
        if (!Storage::disk('public')->exists('signatures')) {
            Storage::disk('public')->makeDirectory('signatures');
        }

        // Pindahkan gambar hasil resize ke direktori permanen
        Storage::disk('public')->put($signaturePath, file_get_contents($tempImagePath));

        // Hapus file sementara setelah proses selesai
        unlink($tempImagePath);

        // Membuat ID atau hash unik untuk tanda tangan
        $signatureUrl = asset('/signature/' . $ajuan->id); // Gunakan hash dari data base64 tanda tangan

        // Buat QR Code dengan ID / Hash
        $qrCode = new QrCode($signatureUrl); // Gunakan hash sebagai data untuk QR Code
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Simpan QR Code ke dalam file
        $barcodeFileName = 'barcode_' . $ajuan->id . '_' . time() . '.png';
        $barcodePath = 'barcodes/' . $barcodeFileName;

        if (!Storage::disk('public')->exists('barcodes')) {
            Storage::disk('public')->makeDirectory('barcodes');
        }
        Storage::disk('public')->put($barcodePath, $result->getString());

        $ajuan->is_approved = false;
        $ajuan->is_rejected = false;
        $ajuan->is_review = false;
        $ajuan->is_banding = false;

        // Simpan path barcode dan signature
        $ajuan->signature_path = $signaturePath;
        $ajuan->pic_barcode = $barcodePath;
        $ajuan->is_approved = true;
        $ajuan->picSigned_date = now();
        $ajuan->save();

        return redirect()->route('ajuan.index')->with('success', 'Pengajuan berhasil diterima.');
    }

    // Fungsi untuk menampilkan gambar tanda tangan
    public function showSignature($id)
    {
        $ajuan = AjuanSponsorship::findOrFail($id);

        if (!$ajuan->signature_path) {
            abort(404, 'Tanda tangan tidak ditemukan.');
        }

        $signaturePath = storage_path('app/public/' . $ajuan->signature_path);

        return response()->file($signaturePath);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // pastikan user_id adalah kolom yang menghubungkan kedua model
    }

}
