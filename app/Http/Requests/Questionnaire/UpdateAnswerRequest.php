<?php

namespace App\Http\Requests\Questionnaire;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAnswerRequest extends FormRequest
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
        'answers' => 'required|array|min:1',
        'answers.*.id' => 'sometimes|exists:answers,id', // Jika ingin update record spesifik
        'answers.*.question_id' => 'required|exists:questions,id',
        'answers.*.question_option_id' => 'nullable|exists:question_options,id',
        'answers.*.answer_text' => 'nullable|string',
    ];
    }
}
