<?php

namespace App\Contracts\Repositories;

interface JobVacancyRepositoryInterface
{
    public function allActive(); // Mengambil lowongan yang belum expired & aktif
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getByUserId(int $userId);
}
