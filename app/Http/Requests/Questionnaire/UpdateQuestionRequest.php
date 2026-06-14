<?php

namespace App\Http\Requests\Questionnaire;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
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
    //     return [
    //     'kode' => 'sometimes|string|max:50|unique:questions,kode',//**,' . $questionId */
    //     'text' => 'sometimes|string',
    //     'type' => 'sometimes|in:text,number,radio,checkbox,dropdown',
    //     'order' => 'sometimes|integer',
    //     'is_required' => 'sometimes|boolean',
    // ];

    // $questionId = $this->route('question'); // Sesuaikan nama parameter rutenya

    // return [
    //     'kode' => 'sometimes|string|max:50|unique:questions,kode,' . ($questionId ? (is_object($questionId) ? $questionId->id : $questionId) : 'NULL'),
    //     'text' => 'sometimes|string',
    //     'type' => 'sometimes|in:text,number,radio,checkbox,dropdown',
    //     'order' => 'sometimes|integer',
    //     'is_required' => 'sometimes|boolean',
    // ];

    // Pastikan bagian rules di UpdateQuestionRequest kamu seperti ini:
    
        $questionId = $this->route('id'); // Menangkap parameter {id} dari rute API

        return [
            'kode' => 'sometimes|string|max:50|unique:questions,kode,' . ($questionId ?? 'NULL'),
            'text' => 'sometimes|string',
            'type' => 'sometimes|in:text,number,radio,checkbox,dropdown',
            'order' => 'sometimes|integer',
            'is_required' => 'sometimes|boolean',
        ];
    }
}
