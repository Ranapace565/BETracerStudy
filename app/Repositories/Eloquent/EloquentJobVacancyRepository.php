<?php

namespace App\Repositories\Eloquent;

use App\Models\JobVacancy;
use App\Contracts\Repositories\JobVacancyRepositoryInterface;

class EloquentJobVacancyRepository implements JobVacancyRepositoryInterface
{
    protected $model;

    public function __construct(JobVacancy $model)
    {
        $this->model = $model;
    }

    public function allActive()
    {
        return $this->model->where('is_active', true)
            ->where(function($query) {
                $query->whereNull('expired_at')
                      ->orWhere('expired_at', '>=', now());
            })
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function find(int $id)
    {
        return $this->model->with('user')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $job = $this->find($id);
        $job->update($data);
        return $job;
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }

    public function getByUserId(int $userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }
}