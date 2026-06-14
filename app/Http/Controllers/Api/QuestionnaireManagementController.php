<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Questionnaire\StoreQuestionnaireRequest;
use App\Http\Requests\Questionnaire\UpdateQuestionnaireRequest;
use App\Http\Resources\QuestionnaireResource;
use App\Services\QuestionnaireService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionnaireManagementController extends Controller
{
    protected $service;

    public function __construct(QuestionnaireService $service)
    {
        $this->service = $service;
    }

    /**
     * Menampilkan semua daftar paket kuesioner.
     */
    public function index(): JsonResponse
    {
        // Kita panggil all() dari service/repo
        $questionnaires = $this->service->getAllQuestionnaires();

        return response()->json([
            'success' => true,
            'data' => QuestionnaireResource::collection($questionnaires)
        ]);
    }

    /**
     * Membuat paket kuesioner baru.
     */
    public function store(StoreQuestionnaireRequest $request): JsonResponse
    {
        $questionnaire = $this->service->createQuestionnaire($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Paket kuesioner berhasil dibuat.',
            'data' => new QuestionnaireResource($questionnaire)
        ], 201);
    }

    /**
     * Melihat detail satu paket kuesioner beserta pertanyaan di dalamnya.
     */
    public function show(int $id): JsonResponse
    {
        $questionnaire = $this->service->getQuestionnaireById($id);

        return response()->json([
            'success' => true,
            'data' => new QuestionnaireResource($questionnaire)
        ]);
    }

    /**
     * Memperbarui paket kuesioner.
     */
    public function update(UpdateQuestionnaireRequest $request, int $id): JsonResponse
    {
        $questionnaire = $this->service->updateQuestionnaire($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Paket kuesioner berhasil diperbarui.',
            'data' => new QuestionnaireResource($questionnaire)
        ]);
    }

    /**
     * Menghapus paket kuesioner.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->deleteQuestionnaire($id);

        return response()->json([
            'success' => true,
            'message' => 'Paket kuesioner berhasil dihapus.'
        ]);
    }
}