<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataUserController extends Controller
{
    public function index()
    {
        $dataAdmin = User::where('role', 'admin')->get();
        $dataPr = User::where('role', 'pr')->get();
        $dataPengaju = User::where('role', 'pengaju')->get();

        return view('admin.datauser.index', compact('dataAdmin', 'dataPr', 'dataPengaju'), ['title' => 'Data User']);
    }

    public function simpanUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
            'role' => 'required|in:admin,pr', // hanya admin dan pr yang diperbolehkan
            'address' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'address' => $request->address,
        ]);

        // Assign role menggunakan Laravel Permission
        $user->assignRole($request->role);

        return redirect()->route('datauser.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete(); // Hapus data admin
            return redirect()->route('datauser.index')->with('success', 'Data admin berhasil dihapus.');
        } else {
            return redirect()->route('datauser.index')->with('error', 'Data admin tidak ditemukan.');
        }
    }
}
