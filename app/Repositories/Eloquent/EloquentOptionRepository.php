<?php

namespace App\Repositories\Eloquent;

use App\Models\QuestionOption;
use App\Contracts\Repositories\OptionRepositoryInterface;

class EloquentOptionRepository implements OptionRepositoryInterface
{
    protected $model;

    public function __construct(QuestionOption $model)
    {
        $this->model = $model;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $option = $this->find($id);
        $option->update($data);
        return $option;
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }

    public function getByQuestionId(int $questionId)
    {
        return $this->model->where('question_id', $questionId)->orderBy('order', 'asc')->get();
    }
}