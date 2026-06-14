<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthInterfaceService;
use App\Repositories\UserDao;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    protected $authService;
    protected $userDao;

    protected $whitelistEmails = [
        'admin' => ['admin@gmail.com', 'sitichairunisah@gmail.com'],
        'petugas' => ['petugas@gmail.com', 'michaelandrew@gmail.com']
    ];

    public function __construct(AuthInterfaceService $authService, UserDao $userDao)
    {
        $this->authService = $authService;
        $this->userDao = $userDao;
    }

    public function showLoginForm() { return view('Auth.login'); }
    public function showRegisterForm() { return view('Auth.register'); }

    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Cek verifikasi email HANYA untuk warga yang daftar via form (bukan Google)
            if ($user->role === 'warga' && !$user->hasVerifiedEmail() && is_null($user->google_id)) {
                Auth::logout();
                return redirect()->route('verification.notice')
                    ->with('error', 'Akun Warga belum diverifikasi. Silakan cek email Anda.');
            }

            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function processRegister(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $data['role'] = 'warga'; 
        $data['password'] = Hash::make($data['password']);
        
        $user = $this->userDao->create($data);
        
        // --- PERUBAHAN ADA DI SINI ---
        // Memaksa (bypass) Laravel untuk langsung mengirim email notifikasi tanpa lewat sistem Event
        $user->sendEmailVerificationNotification();

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi.');
    }

    // --- METHOD GOOGLE ---
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $role = 'warga';
                $email = strtolower($googleUser->getEmail());
                
                if (in_array($email, $this->whitelistEmails['admin'])) $role = 'admin';
                elseif (in_array($email, $this->whitelistEmails['petugas'])) $role = 'petugas';

                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'role' => $role,
                    'password' => Hash::make(Str::random(24)),
                    'phone' => '-', 'address' => '-', 'latitude' => 0, 'longitude' => 0,
                    'email_verified_at' => now(), 
                ]);
            }

            Auth::login($user);
            $request->session()->regenerate();
            return $this->redirectBasedOnRole($user);
            
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Gagal login via Google.']);
        }
    }

    private function redirectBasedOnRole($user)
    {
        $role = strtolower($user->role);
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'petugas') return redirect()->route('petugas.dashboard');
        return redirect()->route('warga.dashboard');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('welcome')->with('success', 'Berhasil keluar.');
    }
}