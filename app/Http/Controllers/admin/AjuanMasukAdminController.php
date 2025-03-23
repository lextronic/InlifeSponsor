<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\MeetingSchedule;
use App\Models\Pengaju\AjuanSponsorship;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\PengajuanDiterimaEmail;
use App\Mail\PengajuanDitolakEmail;
use App\Mail\JadwalMeetingEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AjuanMasukAdminController extends Controller
{
    //MENAMPILKAN AJUAN YANG MASUK
    public function index()
    {
        $ajuan = AjuanSponsorship::where(function ($query) {
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
            ->get()
            ->map(function ($pengajuan) {
                // Tentukan status berdasarkan logika
                if ($pengajuan->is_review) {
                    $pengajuan->status = 'Review';
                } elseif ($pengajuan->is_rejected) {
                    $pengajuan->status = 'Ditolak';
                } else {
                    $pengajuan->status = 'Menunggu';
                }
                return $pengajuan;
            });

        return view('admin.ajuanmasuk.index', compact('ajuan'), ['title' => 'Ajuan Masuk']);
    }

    public function showajuan($id)
    {
        // Ambil data pengajuan berdasarkan ID
        $pengajuan = AjuanSponsorship::findOrFail($id);
        $prNames = User::where('role', 'PR')->get();

        // Tampilkan view dengan data pengajuan (tanpa menyertakan file proposal)
        return view('admin.ajuanmasuk.show', compact('pengajuan', 'prNames'), ['title' => 'Detail']);
    }

    public function terima($id)
    {
        $pengajuan = AjuanSponsorship::findOrFail($id);
        if ($pengajuan->user) {
            // Update status pengajuan menjadi diterima
            $pengajuan->is_review = true;
            $pengajuan->is_rejected = false;
            $pengajuan->save();
    
            // Kirim email pengajuan diterima ke pengaju
            Mail::to($pengajuan->user->email)->send(new PengajuanDiterimaEmail($pengajuan));
    
            return redirect()->route('ajuanmasuk.index')->with('success', 'Pengajuan telah diterima dan email terkirim.');
        } else {
            return redirect()->route('ajuanmasuk.index')->with('error', 'Pengajuan tidak memiliki pengguna terkait.');
        }
    }

    public function tolak($id)
    {
        $pengajuan = AjuanSponsorship::findOrFail($id);
        if ($pengajuan->user) {
            // Update status pengajuan menjadi ditolak
            $pengajuan->is_rejected = true;
            $pengajuan->is_review = false;
            $pengajuan->save();
    
            // Kirim email pengajuan ditolak ke pengaju
            Mail::to($pengajuan->user->email)->send(new PengajuanDitolakEmail($pengajuan));
    
            return redirect()->route('ajuanmasuk.index')->with('error', 'Pengajuan telah ditolak dan email terkirim.');
        } else {
            return redirect()->route('ajuanmasuk.index')->with('error', 'Pengajuan tidak memiliki pengguna terkait.');
        }
    }

    // Method to view the proposal
    public function viewProposal($id)
    {
        $pengajuan = AjuanSponsorship::findOrFail($id);
        $filePath = storage_path('app/public/' . $pengajuan->proposal); // Adjust the path as necessary

        // Debug log to check the file path
        Log::info('File path for proposal: ' . $filePath);

        if (file_exists($filePath)) {
            return response()->file($filePath);
        } else {
            return abort(404, 'File not found.');
        }
    }

    //MEMBUAT JADWAL MEETING UNTUK PR DAN PENGAJU
    public function scheduleMeeting(Request $request, $id)
    {
        $request->validate([
            'pr_name' => 'required|exists:users,id',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|date_format:H:i',
            'meeting_location' => 'required|string|max:255',
        ]);

        // Simpan detail meeting ke pengajuan
        $pengajuan = AjuanSponsorship::findOrFail($id);
        $pengajuan->id_pr = $request->pr_name;
        $pengajuan->meeting_date = $request->meeting_date;
        $pengajuan->meeting_time = $request->meeting_time;
        $pengajuan->meeting_location = $request->meeting_location;

        // Ubah status pengajuan menjadi diterima
        $pengajuan->is_review = true; // Tetapkan diterima
        $pengajuan->is_rejected = false; // Pastikan tidak ditolak
        $pengajuan->save();
        Mail::to($pengajuan->user->email)->send(new JadwalMeetingEmail($pengajuan));

        return redirect()->route('ajuanmasuk.index')->with('success', 'Meeting telah dijadwalkan.');
    }
}
