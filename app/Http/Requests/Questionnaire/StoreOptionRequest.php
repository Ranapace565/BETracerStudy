<?php

namespace App\Http\Requests\Questionnaire;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOptionRequest extends FormRequest
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
        'question_id' => 'required|exists:questions,id',
        'option_text' => 'required|string|max:255',
        'value' => 'required|string|max:50',
        'order' => 'integer|min:0'
    ];
    }
}
