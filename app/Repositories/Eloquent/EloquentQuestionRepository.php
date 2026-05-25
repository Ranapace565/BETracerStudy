<?php

namespace App\Repositories\Eloquent;

use App\Models\Question;
use App\Contracts\Repositories\QuestionRepositoryInterface;

class EloquentQuestionRepository implements QuestionRepositoryInterface
{
    protected $model;

    public function __construct(Question $model)
    {
        $this->model = $model;
    }

    public function find(int $id)
    {
        return $this->model->with('children')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $question = $this->find($id);
        $question->update($data);
        return $question;
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }

    public function updateOrder(array $orders)
    {
        foreach ($orders as $order) {
            $this->model->where('id', $order['id'])->update(['order' => $order['order']]);
        }
        return true;
    }
}