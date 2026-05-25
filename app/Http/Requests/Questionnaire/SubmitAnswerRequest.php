<?php

namespace App\Http\Requests\Questionnaire;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SubmitAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role === 'alumni';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'answers' => 'required|array',
        'answers.*.question_id' => 'required|exists:questions,id',
        'answers.*.question_option_id' => 'nullable|exists:question_options,id',
        'answers.*.answer_text' => 'nullable|string',
    ];
    }

    public function messages(): array
    {
        return [
            'answers.*.question_id.exists' => 'Pertanyaan yang dijawab tidak valid.',
            'answers.*.question_option_id.exists' => 'Opsi jawaban yang dipilih tidak tersedia.',
        ];
    }
}
