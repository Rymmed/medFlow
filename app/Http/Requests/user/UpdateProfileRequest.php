<?php

namespace App\Http\Requests\user;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $user = auth()->user();
        return [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required', 'email', Rule::unique('users')->ignore($user->id),
            'password' => 'nullable|min:8|confirmed',
            'phone_number' => 'required',
            'dob' => 'required|date',
            'insurance_number' => 'nullable',
            'cin_number' => 'nullable',
            'speciality' => 'nullable',
            'registration_number' => 'nullable',
        ];
    }
}
