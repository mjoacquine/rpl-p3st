<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthInterfaceService;
use App\Repositories\UserDao;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $authService;
    protected $userDao;

    public function __construct(AuthInterfaceService $authService, UserDao $userDao)
    {
        $this->authService = $authService;
        $this->userDao = $userDao;
    }

    public function showLoginForm()
    {
        return view('Auth.login');
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $user = $this->authService->attemptWebLogin($credentials);
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!');
            } elseif ($user->role === 'petugas') {
                return redirect()->route('petugas.dashboard')->with('success', 'Selamat datang Petugas Lapangan!');
            }
            return redirect()->route('warga.dashboard')->with('success', 'Selamat datang di Aplikasi P3ST!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function showRegisterForm()
    {
        return view('Auth.register');
    }

    public function processRegister(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'warga';

        $this->userDao->create($data);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk.');
    }

    public function logout()
    {
        $this->authService->performWebLogout();
        return redirect()->route('welcome')->with('success', 'Berhasil keluar dari sistem.');
    }

    // --- ENDPOINT UNTUK MOBILE APP ---
    public function apiLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $this->authService->generateApiToken($user);
            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'token' => $token,
                'user' => $user
            ], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'Kredensial salah.'], 401);
    }

    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => 'success', 'message' => 'Token berhasil dihapus.'], 200);
    }
}