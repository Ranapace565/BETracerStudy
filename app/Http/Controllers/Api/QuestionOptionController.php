<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Questionnaire\StoreOptionRequest;
use App\Http\Requests\Questionnaire\UpdateOptionRequest;
use App\Http\Resources\QuestionOptionResource;
use App\Services\QuestionOptionService;
use Illuminate\Http\JsonResponse;

class QuestionOptionController extends Controller
{
    protected $service;

    public function __construct(QuestionOptionService $service)
    {
        $this->service = $service;
    }

    /**
     * Menyisipkan opsi jawaban baru ke dalam pertanyaan.
     */
    public function store(StoreOptionRequest $request): JsonResponse
    {
        $option = $this->service->createOption($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Opsi jawaban berhasil ditambahkan.',
            'data' => new QuestionOptionResource($option)
        ], 201);
    }

    /**
     * Memperbarui data opsi jawaban (Typo / Perubahan Bobot Value).
     */
    public function update(UpdateOptionRequest $request, int $id): JsonResponse
    {
        $option = $this->service->updateOption($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Opsi jawaban berhasil diperbarui.',
            'data' => new QuestionOptionResource($option)
        ]);
    }

    /**
     * Menghapus satu opsi jawaban.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->deleteOption($id);

        return response()->json([
            'success' => true,
            'message' => 'Opsi jawaban berhasil dihapus.'
        ]);
    }
}