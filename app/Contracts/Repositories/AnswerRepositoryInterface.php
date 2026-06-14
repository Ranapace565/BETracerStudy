<?php

namespace App\Contracts\Repositories;

interface AnswerRepositoryInterface
{
    public function upsertAnswers(int $alumniId, array $answers);
    public function getAlumniAnswers(int $alumniId, int $questionnaireId);

    public function getCountByQuestionOption(int $questionId);
}
