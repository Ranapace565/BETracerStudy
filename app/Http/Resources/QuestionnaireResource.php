<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionnaireResource extends JsonResource
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
        //     'parent_id' => $this->parent_id,
        //     'kode' => $this->kode,
        //     'text' => $this->text,
        //     'type' => $this->type,
        //     'order' => $this->order,
        //     'is_required' => (bool) $this->is_required,
        //     // Rekursif: Memanggil Resource yang sama untuk anak-anaknya
        //     'children' => QuestionResource::collection($this->whenLoaded('children')),
        // ];
        return [
            'id' => $this->id,
            'title' => $this->title,
            'year' => $this->year,
            'is_active' => (bool) $this->is_active,
            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
