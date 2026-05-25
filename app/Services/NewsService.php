<?php

namespace App\Services;

use App\Contracts\Repositories\NewsRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsService
{
    protected $newsRepo;

    public function __construct(NewsRepositoryInterface $newsRepo)
    {
        $this->newsRepo = $newsRepo;
    }

    public function getPublishedNews()
    {
        return $this->newsRepo->allPublished();
    }

    public function getNewsBySlug(string $slug)
    {
        return $this->newsRepo->findBySlug($slug);
    }

    public function storeNews(int $userId, array $data)
    {
        $data['user_id'] = $userId;
        
        // Slug ditangani otomatis oleh boot() di Model News yang kita buat sebelumnya
        if (isset($data['thumbnail']) && $data['thumbnail'] instanceof \Illuminate\Http\UploadedFile) {
            $data['thumbnail'] = $data['thumbnail']->store('news_thumbnails', 'public');
        }

        return $this->newsRepo->create($data);
    }

    public function updateNews(int $id, array $data)
    {
        $news = $this->newsRepo->update($id, $data);

        if (isset($data['thumbnail']) && $data['thumbnail'] instanceof \Illuminate\Http\UploadedFile) {
            // Hapus thumbnail lama jika ada
            if ($news->thumbnail) {
                Storage::disk('public')->delete($news->thumbnail);
            }
            $path = $data['thumbnail']->store('news_thumbnails', 'public');
            $this->newsRepo->update($id, ['thumbnail' => $path]);
        }

        return $news;
    }

    public function deleteNews(int $id)
    {
        $news = $this->newsRepo->update($id, []); // Mencari instance untuk hapus file
        if ($news->thumbnail) {
            Storage::disk('public')->delete($news->thumbnail);
        }
        return $this->newsRepo->delete($id);
    }
}