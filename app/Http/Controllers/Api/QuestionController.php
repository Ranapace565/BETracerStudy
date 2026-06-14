<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Questionnaire\StoreQuestionRequest;
use App\Http\Requests\Questionnaire\UpdateQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Services\QuestionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected $service;

    public function __construct(QuestionService $service)
    {
        $this->service = $service;
    }

    /**
     * Detail satu pertanyaan (beserta children-nya jika ada).
     */
    public function show(int $id): JsonResponse
    {
        $question = $this->service->getQuestionById($id);

        return response()->json([
            'success' => true,
            'data' => new QuestionResource($question)
        ]);
    }

    /**
     * Membuat pertanyaan baru (tanpa opsi).
     */
    public function store(StoreQuestionRequest $request): JsonResponse
    {
        $question = $this->service->createQuestion($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil ditambahkan.',
            'data' => new QuestionResource($question)
        ], 201);
    }

    /**
     * Memperbarui data pertanyaan.
     */
    public function update(UpdateQuestionRequest $request, int $id): JsonResponse
    {
        $question = $this->service->updateQuestion($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil diperbarui.',
            'data' => new QuestionResource($question)
        ]);
    }

    /**
     * Menghapus pertanyaan.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->deleteQuestion($id);

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil dihapus.'
        ]);
    }

    /**
     * Mengubah urutan sorting pertanyaan (Drag and Drop).
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:questions,id',
            'orders.*.order' => 'required|integer',
        ]);

        $this->service->reorderQuestions($request->orders);

        return response()->json([
            'success' => true,
            'message' => 'Urutan kuesioner berhasil diperbarui.'
        ]);
    }
}