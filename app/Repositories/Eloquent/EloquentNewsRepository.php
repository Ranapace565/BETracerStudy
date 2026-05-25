<?php

namespace App\Repositories\Eloquent;

use App\Models\News;
use App\Contracts\Repositories\NewsRepositoryInterface;

class EloquentNewsRepository implements NewsRepositoryInterface
{
    protected $model;

    public function __construct(News $model)
    {
        $this->model = $model;
    }

    public function allPublished()
    {
        return $this->model->where('is_published', true)->with('user')->latest()->get();
    }

    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->with('user')->firstOrFail();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $news = $this->model->findOrFail($id);
        $news->update($data);
        return $news;
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }
}