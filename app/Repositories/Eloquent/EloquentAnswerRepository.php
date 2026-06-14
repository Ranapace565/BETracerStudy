<?php

namespace App\Repositories\Eloquent;

use App\Models\Answer;
use App\Contracts\Repositories\AnswerRepositoryInterface;

class EloquentAnswerRepository implements AnswerRepositoryInterface
{
    protected $model;

    public function __construct(Answer $model)
    {
        $this->model = $model;
    }

    public function upsertAnswers(int $alumniId, array $answers)
    {
        foreach ($answers as $ans) {
            $this->model->updateOrCreate(
                [
                    'alumni_id' => $alumniId,
                    'question_id' => $ans['question_id']
                ],
                [
                    'question_option_id' => $ans['question_option_id'] ?? null,
                    'answer_text' => $ans['answer_text'] ?? null,
                ]
            );
        }
        return true;
    }

    public function getAlumniAnswers(int $alumniId, int $questionnaireId)
    {
        return $this->model->where('alumni_id', $alumniId)
            ->whereHas('question', function($q) use ($questionnaireId) {
                $q->where('questionnaire_id', $questionnaireId);
            })->get();
    }

    public function getCountByQuestionOption(int $questionId)
    {
        return $this->model->where('question_id', $questionId)
            ->select('question_option_id', \DB::raw('count(*) as total'))
            ->with(['questionOption:id,option_text'])
            ->groupBy('question_option_id')
            ->get();
    }
}