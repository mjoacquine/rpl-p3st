<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserDao;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userDao;

    public function __construct(UserDao $userDao)
    {
        $this->userDao = $userDao;
    }

    public function index()
    {
        $warga = $this->userDao->getUsersByRole('warga');
        $petugas = $this->userDao->getUsersByRole('petugas');
        return view('Admin.User.index', compact('warga', 'petugas'));
    }

    public function createPetugas()
    {
        return view('Admin.User.create_petugas');
    }

    public function storePetugas(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'petugas';

        $this->userDao->create($data);
        return redirect()->route('admin.user.index')->with('success', 'Petugas Pengepul baru berhasil didaftarkan.');
    }
}