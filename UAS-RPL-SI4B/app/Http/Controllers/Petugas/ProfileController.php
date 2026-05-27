<?php
namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        // Ambil data petugas yang sedang login
        $user = Auth::user();
        return view('petugas.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        // Petugas bisa mengupdate nama dan nomor handphone operasional
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15'
        ]);

        $user = Auth::user();
        
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone
        ]);

        return redirect()->route('petugas.profile.edit')->with('success', 'Profil petugas berhasil diperbarui!');
    }
}