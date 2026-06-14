<?php

namespace App\Services;

use App\Contracts\Repositories\QuestionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class QuestionService
{
    protected $questionRepo;

    public function __construct(QuestionRepositoryInterface $questionRepo)
    {
        $this->questionRepo = $questionRepo;
    }

    public function getQuestionById(int $id)
    {
        return $this->questionRepo->find($id);
    }

    public function createQuestion(array $data)
    {
        return $this->questionRepo->create($data);
    }

    public function updateQuestion(int $id, array $data)
    {
        return $this->questionRepo->update($id, $data);
    }

    // public function deleteQuestion(int $id)
    // {
    //     return $this->questionRepo->delete($id);
    // }

    public function deleteQuestion(int $id)
    {
        return DB::transaction(function () use ($id) {
            // 1. Hapus semua opsi yang menempel pada pertanyaan ini
            \App\Models\QuestionOption::where('question_id', $id)->delete();

            // 2. Hapus (atau tangani jika ada) data jawaban alumni agar tidak error constraint
            \App\Models\Answer::where('question_id', $id)->delete();

            // 3. Hapus pertanyaan utamanya
            return $this->questionRepo->delete($id);
        });
    }

    public function reorderQuestions(array $orders)
    {
        return $this->questionRepo->updateOrder($orders);
    }
}