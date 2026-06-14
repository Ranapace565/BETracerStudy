<?php

namespace App\Services;

use App\Contracts\Repositories\OptionRepositoryInterface;

class QuestionOptionService
{
    protected $optionRepo;

    public function __construct(OptionRepositoryInterface $optionRepo)
    {
        $this->optionRepo = $optionRepo;
    }

    /**
     * Membuat opsi jawaban baru.
     */
    public function createOption(array $data)
    {
        return $this->optionRepo->create($data);
    }

    /**
     * Memperbarui teks atau nilai opsi jawaban.
     */
    public function updateOption(int $id, array $data)
    {
        return $this->optionRepo->update($id, $data);
    }

    /**
     * Menghapus satu opsi jawaban spesifik.
     */
    public function deleteOption(int $id)
    {
        return $this->optionRepo->delete($id);
    }
}