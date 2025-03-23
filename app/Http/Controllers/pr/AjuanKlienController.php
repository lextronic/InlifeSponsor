<?php

namespace App\Http\Controllers\pr;

use App\Http\Controllers\Controller;
use App\Models\Pengaju\AjuanSponsorship;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Gumlet\ImageResize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AjuanKlienController extends Controller
{
    // Menampilan Menu Ajuan Klien 
    public function index()
    {
        $userID = Auth::user()->id;
        // Data untuk tabel "Review"
        $pengajuanReview = AjuanSponsorship::where('is_review', true)
            ->where('id_pr', $userID)
            ->whereNotNull('catatan_meeting')
            ->whereNotNull('benefit')
            ->get();

        // Data untuk tabel "Banding"
        $pengajuanBanding = AjuanSponsorship::where('is_banding', true)
            ->where('id_pr', $userID)
            ->whereNotNull('catatan_meeting')
            ->whereNotNull('benefit')
            ->get();

        // Data untuk tabel "Diterima"
        $pengajuanDiterima = AjuanSponsorship::where('is_approved', true)
            ->where('id_pr', $userID)
            ->whereNotNull('catatan_meeting')
            ->whereNotNull('benefit')
            ->get();

        // Data untuk tabel "Ditolak"
        $pengajuanDitolak = AjuanSponsorship::where('is_rejected', true)
            ->where('id_pr', $userID)
            ->whereNotNull('catatan_meeting')
            ->whereNotNull('benefit')
            ->get();
        return view('pr.ajuanklien.index', compact('pengajuanReview', 'pengajuanBanding', 'pengajuanDiterima', 'pengajuanDitolak'), ['title' => 'Ajuan Klien']);
    }

    public function show($id)
    {
        // Ambil data pengajuan berdasarkan ID
        $pengajuan = AjuanSponsorship::findOrFail($id);

        // Kirim data ke view
        return view('pr.ajuanklien.show', compact('pengajuan'), ['title' => 'Detail']);
    }

    public function terima_banding(Request $request, $id)
    {
        $request->validate([
            'benefits' => 'required|array|min:1', // Memastikan ada benefit yang dipilih
            'benefits.*' => 'string|max:255', // Validasi untuk setiap benefit
        ]);

        $pengajuan = AjuanSponsorship::findOrFail($id);

        $pengajuan->is_review = true; // Tetapkan review
        $pengajuan->is_rejected = false; // Pastikan tidak ditolak
        $pengajuan->is_banding = false;
        $pengajuan->benefit = json_encode($request->input('benefits', []));
        $pengajuan->save();

        return redirect()->route('ajuanklien.index')->with('success', 'Pengajuan telah diterima.');
    }

    public function tolak_banding(Request $request, $id)
    {
        // Validasi data (opsional, jika ingin alasan ditolak wajib diisi)
        $request->validate([
            'catatan' => 'required|string|max:1000', // Catatan alasan penolakan
        ]);

        // Ambil data pengajuan
        $pengajuan = AjuanSponsorship::findOrFail($id);

        // Update status dan alasan
        $pengajuan->is_rejected = true;
        $pengajuan->is_banding = false;
        $pengajuan->is_review = false;
        $pengajuan->is_approved = false;
        $pengajuan->catatan_meeting = $request->input('catatan'); // Simpan alasan di catatan meeting
        $pengajuan->save();

        return redirect()->route('ajuanklien.index')->with('error', 'Pengajuan telah ditolak.');
    }


    public function storeSignaturePR(Request $request, $id)
    {
        // Validasi Input
        $request->validate([
            'signature' => 'required', // Tanda tangan dalam bentuk base64
        ]);

        $signatureData = $request->input('signature');

        // Tentukan batas ukuran maksimal tanda tangan (misalnya 500 KB)
        $maxSize = 500000; // 500 KB
        $signatureSize = strlen(rtrim($signatureData, '='));

        // Jika ukuran tanda tangan lebih besar dari batas, beri error
        if ($signatureSize > $maxSize) {
            return back()->withErrors(['signature' => 'Tanda tangan terlalu besar.']);
        }

        // Ambil data pengajuan berdasarkan ID
        $pengajuan = AjuanSponsorship::findOrFail($id);

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

        $fileName = 'signature_' . $pengajuan->id . '_' . time() . '.png';
        $filePath = 'signatures/' . $fileName;

        // Pastikan direktori untuk signature ada
        if (!Storage::disk('public')->exists('signatures')) {
            Storage::disk('public')->makeDirectory('signatures');
        }

        // Pindahkan gambar hasil resize ke direktori permanen
        Storage::disk('public')->put($filePath, file_get_contents($tempImagePath));

        // Hapus file sementara setelah proses selesai
        unlink($tempImagePath);

        // Membuat ID atau hash unik untuk tanda tangan
        $signatureUrl = asset('/signature/' . $pengajuan->id); // Gunakan hash dari data base64 tanda tangan

        // Buat QR Code dengan ID / Hash
        $qrCode = new QrCode($signatureUrl); // Gunakan hash sebagai data untuk QR Code
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Simpan QR Code ke dalam file
        $barcodeFileName = 'barcode_' . $pengajuan->id . '_' . time() . '.png';
        $barcodePath = 'barcodes/' . $barcodeFileName;

        if (!Storage::disk('public')->exists('barcodes')) {
            Storage::disk('public')->makeDirectory('barcodes');
        }
        Storage::disk('public')->put($barcodePath, $result->getString());


        // Simpan path barcode dan signature
        $pengajuan->signature_PR = $filePath;
        $pengajuan->pr_barcode = $barcodePath;
        $pengajuan->is_approved = false;
        $pengajuan->is_aktif = true;
        $pengajuan->save();

        return redirect()->route('distribusi.index')->with('success', 'Pengajuan berhasil diterima.');
    }
}
