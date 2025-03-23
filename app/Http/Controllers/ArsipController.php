<?php

namespace App\Http\Controllers;

use App\Models\Pengaju\AjuanSponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArsipController extends Controller
{
    function index()
    {
        $user = auth()->user();

        // Jika pengguna adalah pengaju, tampilkan hanya data miliknya
        if (in_array($user->role, ['pengaju'])) {
            $ajuanDitolak = AjuanSponsorship::where('id_pengaju', $user->id)
                ->where('is_rejected', true)
                ->get();

            $ajuanDone = AjuanSponsorship::where('id_pengaju', $user->id)
                ->where('is_Done', true)
                ->get();

            return view('pengaju.arsip.index', compact('ajuanDitolak', 'ajuanDone'), ['title' => 'Arsip']);

            // Jika pengguna adalah pr, tampilkan hanya data miliknya
        } elseif (in_array($user->role, ['pr'])) {
            $ajuanDitolak = AjuanSponsorship::where('id_pr', $user->id)
                ->where('is_rejected', true)
                ->get();

            $ajuanDone = AjuanSponsorship::where('id_pr', $user->id)
                ->where('is_Done', true)
                ->get();

            return view('pr.arsip.index', compact('ajuanDitolak', 'ajuanDone'), ['title' => 'Arsip']);
        } else {
            $ajuanDitolak = AjuanSponsorship::where('is_rejected', true)->get();

            $ajuanDone = AjuanSponsorship::where('is_Done', true)->get();

            return view('admin.arsip.index', compact('ajuanDitolak', 'ajuanDone'), ['title' => 'Arsip']);
        }
    }

    public function show($id)
    {

        $user = auth()->user();
        $pengajuan = AjuanSponsorship::findOrFail($id);

        if (in_array($user->role, ['pengaju'])) {
            return view('pengaju.arsip.show', compact('pengajuan'), ['title' => 'Detail']);
        } elseif (in_array($user->role, ['pr'])) {
            return view('pr.arsip.show', compact('pengajuan'), ['title' => 'Detail']);
        } else {
            return view('admin.arsip.show', compact('pengajuan'), ['title' => 'Detail']);
        }
    }
}
