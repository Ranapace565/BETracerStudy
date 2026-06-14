<?php

namespace App\Repositories\Eloquent;

use App\Models\Questionnaire;
use App\Models\Question;
use App\Contracts\Repositories\QuestionnaireRepositoryInterface;

class EloquentQuestionnaireRepository implements QuestionnaireRepositoryInterface
{
    protected $model;

    public function __construct(Questionnaire $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    // public function find(int $id)
    // {
    //     return $this->model->with(['questions.children'])->findOrFail($id);
    // }

    public function find(int $id)
    {
        return $this->model->with([
            'questions' => function($query) {
                $query->whereNull('parent_id')->orderBy('order', 'asc');
            },
            'questions.options', // <--- Memuat opsi untuk pertanyaan induk
            'questions.children.options' // <--- Memuat opsi untuk sub-pertanyaan bersyarat
        ])->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }

    public function getActiveWithQuestions()
    {
        return $this->model->where('is_active', true)
            ->with(['questions' => function($query) {
                $query->whereNull('parent_id')->orderBy('order', 'asc');
            }, 'questions.children'])
            ->first();
    }

    public function saveQuestion(int $questionnaireId, array $data)
    {
        $data['questionnaire_id'] = $questionnaireId;
        return Question::updateOrCreate(['id' => $data['id'] ?? null], $data);
    }
}