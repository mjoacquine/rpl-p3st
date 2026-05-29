<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserDao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $userDao;

    public function __construct(UserDao $userDao)
    {
        $this->userDao = $userDao;
    }

    /**
     * Menampilkan Halaman Edit Profil Petugas
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Membuka file di resources/views/Petugas/Profile/edit.blade.php
        // Pastikan nama folder di laptopmu menggunakan huruf kapital (Petugas/Profile) 
        // agar cocok dengan string di bawah ini.
        return view('Petugas.Profile.edit', compact('user'));
    }

    /**
     * Memproses Update Data Profil (Nama & Telepon)
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $this->userDao->update(Auth::id(), $data);
        
        // Perbaikan: Diubah ke huruf kecil semua agar sesuai dengan name('petugas.profile.edit') di web.php
        return redirect()->route('petugas.profile.edit')->with('success', 'Profil armada berhasil diupdate.');
    }

    /**
     * Memproses Perubahan Password Kerja Petugas
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'Kata sandi lama operasional keliru.']);
        }

        $this->userDao->update(Auth::id(), [
            'password' => Hash::make($request->password)
        ]);

        // Perbaikan: Diubah ke huruf kecil semua
        return redirect()->route('petugas.profile.edit')->with('success', 'Sandi operasional berhasil diganti.');
    }

    /**
     * Memproses Sinkronisasi Koordinat GPS Fleet Kendaraan Petugas
     */
    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Mengirim data koordinat rill ke Data Access Object (DAO) untuk disimpan ke database
        $this->userDao->update(Auth::id(), [
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        // Perbaikan: Diubah ke huruf kecil semua
        return redirect()->route('petugas.profile.edit')->with('success', 'GPS tracking posisi armada berhasil diperbarui.');
    }
}