<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AkunController extends Controller
{
    // Display the user profile
    public function index()
    {
        try {
            if (Auth::check()) {
                // Ambil data pengguna yang sedang login
                $user = Auth::user();  // Mengambil pengguna yang login

                // Pengecekan role pengguna
                if ($user->role == 'admin') {
                    // Jika admin, arahkan ke halaman akun admin
                    return view('admin.akun.index', compact('user'), ['title' => 'Akun Saya']);  // Ganti dengan rute yang sesuai
                } elseif ($user->role == 'pr') {
                    // Jika PR, arahkan ke halaman profil PR
                    return view('pr.akun.index', compact('user'), ['title' => 'Akun Saya']);  // Ganti dengan rute yang sesuai
                } elseif ($user->role == 'pengaju') {
                    // Jika pengaju, arahkan ke halaman profil pengaju
                    return view('pengaju.akun.index', compact('user'), ['title' => 'Akun Saya']);  // Ganti dengan rute yang sesuai
                }

                // Jika role tidak ditemukan, arahkan ke halaman login
                return redirect()->route('login')->withErrors(['error' => 'Invalid role.']);
            } else {
                // Jika pengguna belum login, arahkan ke halaman login
                return redirect()->route('login')->withErrors(['error' => 'Please log in to view your profile.']);
            }
        } catch (Exception $e) {
            // Jika terjadi error, kembali ke halaman sebelumnya dengan pesan error
            return back()->withErrors(['error' => 'An error occurred while loading your profile.']);
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return back()->with('error', 'Pengguna tidak ditemukan!');
        }

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'required|string|max:255',
        ]);

        // Update data
        DB::table('users')->where('id', $user->id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
        ]);


        return redirect()->back()->with('success', 'Akun berhasil diperbarui!');
    }
}
