<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaju\AjuanSponsorship;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    // Menampilkan halaman dashboard admin
    public function dashboardAdminShow()
    {
        return view('admin.dashboard.index', ['title' => 'Dashboard']);
    }

    // API untuk mendapatkan data jumlah pengajuan per tahun
    public function getYearlyData()
    {
        $yearlyData = AjuanSponsorship::selectRaw('YEAR(created_at) as year, COUNT(*) as total')
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('total', 'year');

        return response()->json($yearlyData);
    }

    // API untuk mendapatkan data jumlah pengajuan per bulan
    public function getMonthlyData($year)
    {
        $monthlyData = AjuanSponsorship::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        return response()->json($monthlyData);
    }

    // API untuk mendapatkan data jumlah pengajuan berdasarkan status di bulan tertentu
    public function getStatusData($year, $month)
    {
        $statusData = AjuanSponsorship::selectRaw("
            SUM(CASE WHEN is_aktif = 1 THEN 1 ELSE 0 END) as aktif,
            SUM(CASE WHEN is_rejected = 1 THEN 1 ELSE 0 END) as ditolak,
            SUM(CASE WHEN is_approved = 0 AND is_review = 1 AND is_rejected = 0 THEN 1 ELSE 0 END) as menunggu
        ")
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->first();

        return response()->json($statusData);
    }
}
