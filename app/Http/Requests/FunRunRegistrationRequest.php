<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FunRunRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'ext_name' => 'nullable|string|max:10',
            'division' => 'required|string',
            'section' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'sex' => 'required|in:Male,Female',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_number' => 'required|string|max:20',
            'race_category' => 'required|string',
            'health_consent_form' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }
}
