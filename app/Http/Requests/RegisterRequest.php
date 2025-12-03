<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'username' => 'required|string|max:50|unique:dataadmin,username',
            'nama' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,guru,siswa',
        ];

        // Validasi tambahan untuk guru
        if ($this->input('role') === 'guru') {
            $rules['mapel'] = 'required|string|max:100';
        }

        // Validasi tambahan untuk siswa
        if ($this->input('role') === 'siswa') {
            $rules['tb'] = 'required|numeric|min:30|max:250';
            $rules['bb'] = 'required|numeric|min:10|max:200';
        }

        return $rules;
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'mapel.required' => 'Mata pelajaran wajib diisi untuk guru.',
            'tb.required' => 'Tinggi badan wajib diisi untuk siswa.',
            'bb.required' => 'Berat badan wajib diisi untuk siswa.',
        ];
    }
}
