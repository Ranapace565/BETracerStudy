<?php

namespace App\Repositories\Eloquent;

use App\Models\Alumni;
use App\Contracts\Repositories\AlumniRepositoryInterface;
use App\Models\Alumnis;

class EloquentAlumniRepository implements AlumniRepositoryInterface
{
    protected $model;

    public function __construct(Alumni $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with('user')->get();
    }

    public function find(int $id)
    {
        return $this->model->with('user')->findOrFail($id);
    }

    public function findByUserId(int $userId)
    {
        return $this->model->where('user_id', $userId)->first();
    }

    public function findByNim(string $nim)
    {
        return $this->model->where('nim', $nim)->first();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $alumni = $this->find($id);
        $alumni->update($data);
        return $alumni;
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }

    public function filterByYear(int $year)
    {
        return $this->model->where('tahun_lulus', $year)->get();
    }
}