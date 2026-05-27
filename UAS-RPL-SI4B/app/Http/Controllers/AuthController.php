<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi input form termasuk pilihan role
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'role' => ['required', 'string', 'in:admin,petugas,warga'],
        ]);

        $remember = $request->has('remember');
        
        // Pisahkan data email & password untuk proses Auth::attempt
        $authData = ['email' => $credentials['email'], 'password' => $credentials['password']];

        // 2. Cek kecocokan email & password
        if (Auth::attempt($authData, $remember)) {
            $user = Auth::user();

            // 3. VERIFIKASI KETAT: Cocokkan role pilihan user dengan role di database
            if ($user->role !== $request->role) {
                Auth::logout(); // Putuskan session jika tidak cocok
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'role' => 'Akun Anda tidak terdaftar sebagai ' . ucfirst($request->role) . '!',
                ])->onlyInput('email');
            }

            // Jika sukses, regenerasi session
            $request->session()->regenerate();

            // 4. Redirect sesuai rute aman masing-masing aktor
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('/admin/katalog')->with('success', 'P3ST: Login Admin Berhasil!');
                case 'petugas':
                    return redirect()->intended('/petugas/tugas')->with('success', 'P3ST: Selamat Bekerja Petugas!');
                case 'warga':
                    return redirect()->intended('/warga/booking')->with('success', 'P3ST: Selamat Datang Warga Palembang!');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Otomatis tersimpan sebagai 'warga' demi keamanan
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'warga', 
        ]);

        Auth::login($user);

        return redirect('/warga/booking')->with('success', 'Pendaftaran Akun P3ST Berhasil!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil keluar dari sistem P3ST.');
    }
}