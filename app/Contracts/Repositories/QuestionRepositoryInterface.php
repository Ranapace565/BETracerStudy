<?php

namespace App\Contracts\Repositories;

interface QuestionRepositoryInterface
{
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function updateOrder(array $orders); // Untuk fitur mengurutkan pertanyaan
}
