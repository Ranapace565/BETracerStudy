<?php

namespace App\Http\Requests\Questionnaire;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'questionnaire_id' => 'required|exists:questionnaires,id',
            'parent_id' => 'nullable|exists:questions,id',
            'kode' => 'required|string|max:50|unique:questions,kode,' . ($this->question ?? 'NULL'),
            'text' => 'required|string',
            'type' => 'required|in:text,number,radio,checkbox,dropdown',
            'order' => 'integer|min:0',
            'is_required' => 'boolean',
        ];
    }
}
