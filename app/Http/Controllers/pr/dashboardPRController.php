<?php

namespace App\Http\Controllers\pr;

use App\Http\Controllers\Controller;
use App\Models\Pengaju\AjuanSponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardPRController extends Controller
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

        $distribusi = AjuanSponsorship::where('id_pr', $userID)
            ->where('is_aktif', true)
            ->get();

        return view('pr.dashboard.index', compact('meetings', 'distribusi'), ['title' => 'Dashboard']);
    }
}
