<?php

namespace App\Services;

use App\Contracts\Repositories\AlumniRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlumniService
{
    protected $alumniRepo;
    protected $userRepo;

    public function __construct(
        AlumniRepositoryInterface $alumniRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->alumniRepo = $alumniRepo;
        $this->userRepo = $userRepo;
    }

    public function getProfileByUserId(int $userId)
    {
        return $this->alumniRepo->findByUserId($userId);
    }

    // public function updateProfile(int $userId, array $data)
    // {
    //     return DB::transaction(function () use ($userId, $data) {
    //         $alumni = $this->alumniRepo->findByUserId($userId);

    //         // Logika upload foto jika ada
    //         if (isset($data['img_profile']) && $data['img_profile'] instanceof \Illuminate\Http\UploadedFile) {
    //             // Hapus foto lama jika ada
    //             if ($alumni->img_profile) {
    //                 Storage::delete($alumni->img_profile);
    //             }
    //             $data['img_profile'] = $data['img_profile']->store('profiles', 'public');
    //         }

    //         return $this->alumniRepo->update($alumni->id, $data);
    //     });
    // }

    // public function updateProfile(int $userId, array $data)
    // {
    //     return DB::transaction(function () use ($userId, $data) {
    //         // 1. Ambil instance User dan Alumni
    //         $user = User::findOrFail($userId);
    //         $alumni = $this->alumniRepo->findByUserId($userId);

    //         // 2. Update tabel 'users' (Username & Email)
    //         $userData = [];
    //         // Kita petakan input 'name' dari Postman ke kolom 'username' di DB
    //         if (isset($data['name'])) {
    //             $userData['username'] = $data['name'];
    //         }
    //         if (isset($data['email'])) {
    //             $userData['email'] = $data['email'];
    //         }
    //         // Tambahkan update password jika ada
    //         if (isset($data['password'])) {
    //             $userData['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
    //         }

    //         if (!empty($userData)) {
    //             $user->update($userData);
    //         }

    //         // 3. Update tabel 'alumnis' (NIM, NIK, Status, dll)
    //         // Pastikan alumniRepo->update menggunakan ID alumni yang benar
    //         return $this->alumniRepo->update($alumni->id, $data);
    //     });
    // }

    public function updateProfile(int $userId, array $data)
    {
        return DB::transaction(function () use ($userId, $data) {
            // 1. Ambil instance User dan Alumni
            $user = \App\Models\User::findOrFail($userId);
            $alumni = $this->alumniRepo->findByUserId($userId);

            // 2. Update data di tabel 'users' (Email & Username)
            $userData = [];
            if (isset($data['name'])) {
                $userData['username'] = $data['name'];
            }
            if (isset($data['email'])) {
                $userData['email'] = $data['email'];
            }
            
            // Update password jika disertakan dalam request
            if (isset($data['password'])) {
                $userData['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
            }

            if (!empty($userData)) {
                $user->update($userData);

                // dd($user->fresh()->email);
            }

            // 3. Update data di tabel 'alumnis' (NIM, NIK, Status, dll)
            // Kita tetap memanggil repo untuk update bagian fungsional alumni
            return $this->alumniRepo->update($alumni->id, $data);
        });
    }

    public function getAllAlumni()
    {
        return $this->alumniRepo->all();
    }
}
