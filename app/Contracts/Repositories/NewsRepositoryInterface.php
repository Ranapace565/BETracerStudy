<?php

namespace App\Contracts\Repositories;

interface NewsRepositoryInterface
{
    public function allPublished();
    public function findBySlug(string $slug);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
