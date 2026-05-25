<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alumni\UpdateAlumniRequest;
use App\Http\Resources\AlumniResource;
use App\Services\AlumniService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    protected $alumniService;

    public function __construct(AlumniService $alumniService)
    {
        $this->alumniService = $alumniService;
    }

    public function me(Request $request): JsonResponse
    {
        $alumni = $this->alumniService->getProfileByUserId(Auth::id());

        return response()->json([
            'success' => true,
            'data' => new AlumniResource($alumni)
        ]);
    }

    public function update(UpdateAlumniRequest $request): JsonResponse
    {
        $alumni = $this->alumniService->updateProfile(
            Auth::id(), 
            $request->validated()
        );

        return response()->json([
            'success' => true, // Konsisten dengan method lainnya
            'message' => 'Profile updated successfully',
            'data' => new AlumniResource($alumni)
        ]);
    }

    public function index(): JsonResponse
    {
        $alumniList = $this->alumniService->getAllAlumni();

        return response()->json([
            'success' => true,
            'data' => AlumniResource::collection($alumniList)
        ]);
    }
}
