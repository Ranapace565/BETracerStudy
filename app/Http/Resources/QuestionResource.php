<?php

namespace App\Http\Resources;

use App\Http\Resources\QuestionOptionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return [
        //     'id' => $this->id,
        //     'title' => $this->title,
        //     'year' => $this->year,
        //     'is_active' => (bool) $this->is_active,
        //     'questions' => QuestionResource::collection($this->whenLoaded('questions')),
        //     'created_at' => $this->created_at->toDateTimeString(),
        // ];

        return [
        'id' => $this->id,
        'parent_id' => $this->parent_id,
        'kode' => $this->kode,
        'text' => $this->text,
        'type' => $this->type,
        'order' => $this->order,
        'is_required' => (bool) $this->is_required,
        
        // Memuat daftar opsi jawaban jika ada (untuk radio/checkbox/dropdown)
        'options' => QuestionOptionResource::collection($this->whenLoaded('options')),
        
        // Memuat sub-pertanyaan (rekursif)
        'children' => QuestionResource::collection($this->whenLoaded('children')),
    ];
    }
}
