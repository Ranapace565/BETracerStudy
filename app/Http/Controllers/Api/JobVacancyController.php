<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\StoreJobVacancyRequest;
use App\Http\Requests\Job\UpdateJobVacancyRequest;
use App\Http\Resources\JobVacancyResource;
use App\Services\JobVacancyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobVacancyController extends Controller
{
    protected $service;

    public function __construct(JobVacancyService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $jobs = $this->service->getAllActiveJobs();
        return response()->json([
            'success' => true,
            'data' => JobVacancyResource::collection($jobs)
        ]);
    }

    public function store(StoreJobVacancyRequest $request): JsonResponse
    {
        $job = $this->service->storeJob(Auth::id(), $request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Lowongan kerja berhasil diterbitkan',
            'data' => new JobVacancyResource($job)
        ], 201);
    }

    public function update(UpdateJobVacancyRequest $request, int $id): JsonResponse
    {
        $job = $this->service->updateJob($id, $request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Lowongan kerja berhasil diperbarui',
            'data' => new JobVacancyResource($job)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        // Policy check dilakukan di Request atau di sini
        $this->service->deleteJob($id);
        return response()->json([
            'success' => true,
            'message' => 'Lowongan kerja berhasil dihapus'
        ]);
    }
}
