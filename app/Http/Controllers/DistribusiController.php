<?php

namespace App\Http\Controllers;

use App\Models\Pengaju\AjuanSponsorship;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class DistribusiController extends Controller
{
    function index()
    {
        $user = auth()->user();

        // Filter data berdasarkan peran pengguna
        if (in_array($user->role, ['pengaju'])) {
            $distribusi = AjuanSponsorship::where('id_pengaju', $user->id)
                ->where('is_aktif', true)
                ->get();
        } elseif (in_array($user->role, ['pr'])) {
            $distribusi = AjuanSponsorship::where('id_pr', $user->id)
                ->where('is_aktif', true)
                ->get();
        } else {
            $distribusi = AjuanSponsorship::where('is_aktif', true)->get();
        }

        // Hitung progres distribusi untuk setiap ajuan
        foreach ($distribusi as $ajuan) {
            $benefits = json_decode($ajuan->benefit, true) ?? []; // Total benefit
            $uploadedDocs = json_decode($ajuan->dokumentasi_distribusi, true) ?? []; // Dokumentasi yang diunggah

            $totalBenefits = count($benefits);
            $distributedBenefits = count(array_intersect(array_keys($uploadedDocs), $benefits));

            $ajuan->progress = $totalBenefits > 0
                ? round(($distributedBenefits / $totalBenefits) * 100)
                : 0; // Jika tidak ada benefit, progress = 0
        }

        // Pilih view berdasarkan peran pengguna
        if ($user->role === 'pengaju') {
            return view('pengaju.distribusi.index', compact('distribusi'), ['title' => 'Distribusi Benefit']);
        } elseif ($user->role === 'pr') {
            return view('pr.distribusi.index', compact('distribusi'), ['title' => 'Distribusi Benefit']);
        } else {
            return view('admin.distribusi.index', compact('distribusi'), ['title' => 'Distribusi Benefit']);
        }
    }

    public function show($id)
    {

        $user = auth()->user();
        $pengajuan = AjuanSponsorship::findOrFail($id);
        $pengajuan->pr_name = $user->name;

        if (in_array($user->role, ['pengaju'])) {
            return view('pengaju.distribusi.show', compact('pengajuan'), ['title' => 'Detail']);
        } elseif (in_array($user->role, ['pr'])) {
            return view('pr.distribusi.show', compact('pengajuan'), ['title' => 'Detail']);
        } else {
            return view('admin.distribusi.show', compact('pengajuan'), ['title' => 'Detail']);
        }
    }

    public function uploadDokumentasi(Request $request)
    {
        $request->validate([
            'dokumen' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'benefit_key' => 'required|string',
            'pengajuan_id' => 'required|exists:ajuan_sponsorships,id',
        ]);

        $pengajuan = AjuanSponsorship::findOrFail($request->pengajuan_id);

        // Pastikan benefit key valid
        $selected_benefits = json_decode($pengajuan->benefit, true) ?? [];
        if (!in_array($request->benefit_key, $selected_benefits)) {
            return redirect()->back()->withErrors(['error' => 'Benefit tidak valid.']);
        }

        // Upload file dan simpan path
        $file = $request->file('dokumen');
        $filePath = $file->store('dokumen_distribusi', 'public'); // Menyimpan file di folder 'dokumen_distribusi'

        // Menyimpan dokumentasi pada benefit yang dipilih
        $uploadedDocs = json_decode($pengajuan->dokumentasi_distribusi ?? '[]', true);
        $uploadedDocs[$request->benefit_key] = $filePath;
        $pengajuan->dokumentasi_distribusi = json_encode($uploadedDocs);
        $pengajuan->save();

        return redirect()->route('distribusi.show', $pengajuan->id)->with('success', 'Dokumentasi berhasil diunggah');
    }

    public function distribusiSelesai($id)
    {

        // Ambil data pengajuan
        $distribusi = AjuanSponsorship::findOrFail($id);

        // Update status dan alasan
        $distribusi->is_rejected = false;
        $distribusi->is_banding = false;
        $distribusi->is_review = false;
        $distribusi->is_approved = false;
        $distribusi->is_aktif = false;
        $distribusi->is_done = true;
        $distribusi->save();

        return redirect()->route('arsip.index');
    }

    public function preview($id)
    {
        $pengajuan = AjuanSponsorship::with('pr')->findOrFail($id);
        $benefit = json_decode($pengajuan->benefit, true) ?? [];
        $pdf = PDF::loadView('mou.template_mou', [
            'signature_path' => $pengajuan->signature_path,
            'signature_PR' => $pengajuan->signature_PR,
            'event_name' => $pengajuan->event_name,
            'event_date' => $pengajuan->event_date,
            'pr_name' => $pengajuan->pr->name,
            'pic_name'  => $pengajuan->pic_name,
            'location' => $pengajuan->location,
            'organizer_name' => $pengajuan->organizer_name,
            'phone_number' => $pengajuan->phone_number,
            'picSigned_date' => $pengajuan->picSigned_date,
            'benefit' => $benefit,
        ]);

        $mou_path = 'mous/' . $pengajuan->event_name . '.pdf';
        Storage::put($mou_path, $pdf->output());

        $pengajuan->mou_path = $mou_path;
        $pengajuan->save();

        $filename = str_replace(' ', '_', $pengajuan->event_name) . '_MOU.pdf';

        return response()->stream(function () use ($pdf) {
            echo $pdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
