<?php

namespace App\Repositories;

use App\Models\User;

class UserDao
{
    public function getUsersByRole($role)
    {
        return User::where('role', $role)->latest()->get();
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        // Enkripsi password dilakukan di level service atau controller sebelumnya
        return User::create($data);
    }

    public function update($id, array $data)
    {
        $user = $this->findById($id);
        $user->update($data);
        return $user;
    }

    public function updateLocation($id, $lat, $long)
    {
        $user = $this->findById($id);
        $user->update([
            'latitude' => $lat,
            'longitude' => $long
        ]);
        return $user;
    }
}