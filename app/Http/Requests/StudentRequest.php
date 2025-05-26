<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . ($this->student?->id ?? ''),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date',
            'student_id' => 'required|string|unique:students,student_id,' . ($this->student?->id ?? ''),
            'class' => 'nullable|string|max:50',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'student_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('students')->ignore($this->student),
            ],
            'group_id' => 'required|string|max:10',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'nullable|in:ACTIVE,INACTIVE',
        ];

        // Password is required only for new students
        if (!$this->student) {
            $rules['password'] = 'required|min:6';
        } else {
            $rules['password'] = 'nullable|min:6';
        }

        return $rules;
    }
} 