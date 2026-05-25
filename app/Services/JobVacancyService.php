<?php

namespace App\Services;

use App\Contracts\Repositories\JobVacancyRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class JobVacancyService
{
    protected $jobRepo;

    public function __construct(JobVacancyRepositoryInterface $jobRepo)
    {
        $this->jobRepo = $jobRepo;
    }

    public function getAllActiveJobs()
    {
        return $this->jobRepo->allActive();
    }

    public function storeJob(int $userId, array $data)
    {
        $data['user_id'] = $userId;

        if (isset($data['poster_image']) && $data['poster_image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['poster_image'] = $data['poster_image']->store('job_posters', 'public');
        }

        return $this->jobRepo->create($data);
    }

    public function updateJob(int $id, array $data)
    {
        $job = $this->jobRepo->find($id);

        if (isset($data['poster_image']) && $data['poster_image'] instanceof \Illuminate\Http\UploadedFile) {
            // Hapus poster lama
            if ($job->poster_image) {
                Storage::disk('public')->delete($job->poster_image);
            }
            $data['poster_image'] = $data['poster_image']->store('job_posters', 'public');
        }

        return $this->jobRepo->update($id, $data);
    }

    public function deleteJob(int $id)
    {
        $job = $this->jobRepo->find($id);
        
        if ($job->poster_image) {
            Storage::disk('public')->delete($job->poster_image);
        }

        return $this->jobRepo->delete($id);
    }
}