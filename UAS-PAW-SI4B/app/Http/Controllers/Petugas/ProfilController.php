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

    public function edit()
    {
        $user = Auth::user();
        return view('Petugas.Profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $this->userDao->update(Auth::id(), $data);
        return redirect()->route('petugas.profile.edit')->with('success', 'Profil armada berhasil diupdate.');
    }

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

        return redirect()->route('petugas.profile.edit')->with('success', 'Sandi operasional berhasil diganti.');
    }

    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $this->userDao->updateLocation(Auth::id(), $request->latitude, $request->longitude);
        return redirect()->route('petugas.profile.edit')->with('success', 'GPS tracking posisi armada berhasil diperbarui.');
    }
}