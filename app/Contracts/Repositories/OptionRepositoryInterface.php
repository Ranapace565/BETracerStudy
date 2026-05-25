<?php

namespace App\Contracts\Repositories;

interface OptionRepositoryInterface
{
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getByQuestionId(int $questionId);
}
