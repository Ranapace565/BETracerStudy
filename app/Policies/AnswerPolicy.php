<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AnswerPolicy
{
    /**
     * Admin bisa melihat semua jawaban, Alumni hanya bisa melihat miliknya.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'alumni';
    }

    /**
     * Memastikan alumni hanya bisa melihat detail jawabannya sendiri.
     */
    public function view(User $user, Answer $answer): bool
    {
        if ($user->role === 'admin') return true;
        
        // Alumni hanya boleh melihat jawaban miliknya (cek via relasi user -> alumni)
        return $user->id === $answer->alumni->user_id;
    }

    /**
     * Semua alumni yang sudah login bisa mengirim jawaban kuesioner.
     */
    public function create(User $user): bool
    {
        return $user->role === 'alumni';
    }

    /**
     * Alumni bisa mengubah jawabannya sendiri selama periode kuesioner aktif.
     */
    public function update(User $user, Answer $answer): bool
    {
        return $user->id === $answer->alumni->user_id;
    }

    /**
     * Hanya admin yang boleh menghapus rekaman jawaban dari database.
     */
    public function delete(User $user, Answer $answer): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Answer $answer): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Answer $answer): bool
    {
        return false;
    }
}
