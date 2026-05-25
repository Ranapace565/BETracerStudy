<?php

namespace App\Contracts\Repositories;

interface QuestionnaireRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    
    /**
     * Mendapatkan kuesioner yang aktif saat ini beserta daftar pertanyaannya.
     */
    public function getActiveWithQuestions();

    /**
     * Menambah atau memperbarui pertanyaan di dalam kuesioner.
     */
    public function saveQuestion(int $questionnaireId, array $data);
}
