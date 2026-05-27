<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserDAO
{
    /**
     * Mengambil semua user berdasarkan role (Warga atau Petugas)
     */
    public function getAllUsersByRole($role)
    {
        return User::where('role', $role)->get();
    }

    /**
     * Membuat user baru
     */
    public function createNewUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
        ]);
    }

    /**
     * Mengupdate data user (Tambahan agar CRUD sempurna)
     */
    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);
        
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        
        $user->update($data);
        return $user;
    }

    /**
     * Menghapus user
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        return $user->delete();
    }
}