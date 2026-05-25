<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'alumni_id' => $this->alumni_id,
            'question_id' => $this->question_id,
            // Menampilkan teks pertanyaan jika relasi di-load
            'question_text' => $this->whenLoaded('question', function() {
                return $this->question->text;
            }),
            'question_option_id' => $this->question_option_id,
            // Menampilkan teks opsi yang dipilih
            'selected_option' => $this->whenLoaded('questionOption', function() {
                return $this->questionOption->option_text;
            }),
            'answer_text' => $this->answer_text, // Untuk jawaban essay/text
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
