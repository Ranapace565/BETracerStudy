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

    public function getTracerStatistics(int $mainQuestionId)
    {
        $rawStats = $this->answerRepo->getCountByQuestionOption($mainQuestionId);
        
        return $rawStats->map(function ($stat) {
            return [
                'option_id' => $stat->question_option_id,
                'label' => $stat->questionOption->option_text ?? 'Isian Teks / Lainnya',
                'total_alumni' => $stat->total
            ];
        });
    }

    public function getAllQuestionnaires()
    {
        return $this->questionnaireRepo->all();
    }

    /**
     * Membuat kuesioner baru.
     */
    public function createQuestionnaire(array $data)
    {
        return $this->questionnaireRepo->create($data);
    }

    /**
     * Mengambil detail kuesioner berdasarkan ID.
     */
    public function getQuestionnaireById(int $id)
    {
        return $this->questionnaireRepo->find($id);
    }

    /**
     * Mengubah data kuesioner.
     */
    public function updateQuestionnaire(int $id, array $data)
    {
        return $this->questionnaireRepo->update($id, $data);
    }

    /**
     * Menghapus kuesioner.
     */
    public function deleteQuestionnaire(int $id)
    {
        return $this->questionnaireRepo->delete($id);
    }
}