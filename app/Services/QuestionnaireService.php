<?php

namespace App\Services;

use App\Contracts\Repositories\QuestionnaireRepositoryInterface;
use App\Contracts\Repositories\AnswerRepositoryInterface;
use App\Contracts\Repositories\AlumniRepositoryInterface;
use Illuminate\Support\Facades\DB;

class QuestionnaireService
{
    protected $questionnaireRepo;
    protected $answerRepo;
    protected $alumniRepo;

    public function __construct(
        QuestionnaireRepositoryInterface $questionnaireRepo,
        AnswerRepositoryInterface $answerRepo,
        AlumniRepositoryInterface $alumniRepo
    ) {
        $this->questionnaireRepo = $questionnaireRepo;
        $this->answerRepo = $answerRepo;
        $this->alumniRepo = $alumniRepo;
    }

    /**
     * Mengambil kuesioner aktif lengkap dengan struktur pertanyaannya.
     */
    public function getActiveQuestionnaire()
    {
        // Logika: ambil kuesioner yang is_active = true
        return $this->questionnaireRepo->getActiveWithQuestions();
    }

    /**
     * Memproses jawaban alumni secara massal (Upsert).
     */
    public function submitAnswers(int $userId, array $answers)
    {
        return DB::transaction(function () use ($userId, $answers) {
            $alumni = $this->alumniRepo->findByUserId($userId);
            
            return $this->answerRepo->upsertAnswers($alumni->id, $answers);
        });
    }

    /**
     * Mendapatkan progres atau hasil jawaban alumni untuk kuesioner tertentu.
     */
    public function getMyAnswers(int $userId, int $questionnaireId)
    {
        $alumni = $this->alumniRepo->findByUserId($userId);
        return $this->answerRepo->getAlumniAnswers($alumni->id, $questionnaireId);
    }
}