<?php

namespace App\Contracts\Repositories;

interface AlumniRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function findByUserId(int $userId); // Penting untuk ambil profil alumni yang sedang login
    public function findByNim(string $nim);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function filterByYear(int $year); // Untuk filter Tracer Study per angkatan
}
