<?php

namespace App\Contracts\Repositories;

interface UserRepositoryInterface
{
    /**
     * Mengambil semua data user (untuk fitur Admin).
     */
    public function all();

    /**
     * Mencari satu user berdasarkan ID.
     */
    public function find(int $id);

    /**
     * Membuat data user baru.
     */
    public function create(array $data);

    /**
     * Memperbarui data user.
     */
    public function update(int $id, array $data);

    /**
     * Menghapus user.
     */
    public function delete(int $id);

    /**
     * Mencari user berdasarkan username (penting untuk login/validasi).
     */
    public function findByUsername(string $username);
}
