<?php

namespace App\Http\Controllers\pr;

use App\Http\Controllers\Controller;
use App\Models\Admin\MeetingSchedule;
use App\Models\Pengaju\AjuanSponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\MeetingDiterimaEmail;
use App\Mail\MeetingDitolakEmail;

class MeetingController extends Controller
{
    public function index()
    {
        $userID = Auth::user()->id; // ID pengguna yang login

        $meetings = AjuanSponsorship::where('is_review', true) // Load relasi ajuan
            ->where('id_pr', $userID)
            ->whereNotNull('meeting_date')
            ->whereNotNull('meeting_time')
            ->whereNotNull('meeting_location')
            ->whereNull('catatan_meeting') // Belum ada hasil meeting
            ->whereNull('dokumen_tambahan')
            ->whereNull('benefit')
            ->get();

        // Kirim data ke view
        return view('pr.meeting.index', compact('meetings'), ['title' => 'Meeting']);
    }

    public function updateMeeting(Request $request, $id)
    {
        $pengajuan = AjuanSponsorship::findOrFail($id);

        // Validasi input
        $request->validate([
            'catatan' => 'nullable|string|max:500',
            'dokumen_tambahan' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'benefit' => 'nullable|array',
            'benefit.*.nama' => 'required|string',
            'benefit.*.jumlah' => 'required|integer',
            'benefit.*.keterangan' => 'nullable|string',
            'status' => 'required|string|in:is_approved,is_rejected,is_review',
        ]);

        // Simpan catatan meeting
        $pengajuan->catatan_meeting = $request->input('catatan');

        // Simpan dokumen tambahan
        if ($request->hasFile('dokumen_tambahan')) {
            $path = $request->file('dokumen_tambahan')->store('dokumen', 'public');
            $pengajuan->dokumen_tambahan = $path;
        }

        // Simpan benefit (disimpan sebagai JSON di database)
        $pengajuan->benefit = $request->has('benefit') ? json_encode($request->input('benefit')) : null;

        // Perbarui status berdasarkan input
        $status = $request->input('status');
        $pengajuan->is_review = $status === 'is_review';
        $pengajuan->is_approved = $status === 'is_approved';
        $pengajuan->is_rejected = $status === 'is_rejected';

        // Jika status tetap review, pastikan tidak mengubah status lainnya
        if ($status === 'is_review') {
            $pengajuan->is_approved = false;
            $pengajuan->is_rejected = false;
        }

        $pengajuan->save();
        // Kirim email jika statusnya diterima

            Mail::to($pengajuan->user->email)->send(new MeetingDiterimaEmail($pengajuan));
        
        return redirect()->route('ajuanklien.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function showMeet(Request $request, $id)
    {
        $userID = Auth::user()->id;

        $pengajuan = AjuanSponsorship::where('id', $id)
            ->where('id_pr', $userID)
            ->firstOrFail();

        // Kirim data ke view
        return view('pr.meeting.show', compact('pengajuan'), ['title' => 'Detail']);
    }

    public function tolak(Request $request, $id)
    {
        // Log input
        // Validasi data (opsional, jika ingin alasan ditolak wajib diisi)
        $request->validate([
            'status' => 'required|string|in:is_approved,is_rejected,is_review',
            'catatan' => 'required|string|max:1000', // Catatan alasan penolakan
        ]);

        // Ambil data pengajuan
        $pengajuan = AjuanSponsorship::findOrFail($id);

        // Update status dan alasan
        $pengajuan->is_rejected = true;
        $pengajuan->is_review = false;
        $pengajuan->is_approved = false;
        $pengajuan->catatan_meeting = $request->input('catatan'); // Simpan alasan di catatan meeting
        $pengajuan->save();
        Mail::to($pengajuan->user->email)->send(new MeetingDitolakEmail($pengajuan));

        return redirect()->route('arsip.index')->with('error', 'Pengajuan telah ditolak.');
    }
}
