<?php

namespace App\Http\Requests\Alumni;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAlumniRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'nim' => 'nullable|string|unique:alumni,nim|max:20',
            'nik' => 'nullable|digits:16',
            'npwp' => 'nullable|string|max:20',
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'tahun_lulus' => 'nullable|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'kdpstmsmh' => 'nullable|string|max:10',
            'privacy_settings' => 'nullable|array',
            'img_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'nullable|string',
        ];
    }
}
