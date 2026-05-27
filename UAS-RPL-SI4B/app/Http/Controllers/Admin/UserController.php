<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $petugas = User::where('role', 'petugas')->get();
        return view('admin.user.index', compact('petugas'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas', // Dikunci otomatis sebagai petugas
        ]);

        return redirect('/admin/user')->with('success', 'Akun petugas lapangan baru berhasil didaftarkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            // Pengecualian email unik untuk ID user yang sedang diedit (Kodinganmu sudah benar di sini)
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect('/admin/user')->with('success', 'Data akun petugas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect('/admin/user')->with('success', 'Akun petugas berhasil dihapus!');
        } catch (\Exception $e) {
            // PERBAIKAN: Penanganan error agar tidak crash
            return redirect('/admin/user')->withErrors(['error' => 'Gagal menghapus! Petugas ini memiliki riwayat transaksi aktif.']);
        }
    }
}