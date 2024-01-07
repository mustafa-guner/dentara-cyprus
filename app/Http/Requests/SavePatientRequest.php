<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePatientRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'phone_no' => 'required|string|max:50',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'gender_id' => 'required|exists:genders,id'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'firstname.required' => 'The firstname field is required.',
            'firstname.string' => 'The firstname must be a string.',
            'firstname.max' => 'The firstname may not be greater than :max characters.',
            'lastname.required' => 'The lastname field is required.',
            'lastname.string' => 'The lastname must be a string.',
            'lastname.max' => 'The lastname may not be greater than :max characters.',
            'phone_no.required' => 'The phone no field is required.',
            'phone_no.string' => 'The phone no must be a string.',
            'phone_no.max' => 'The phone no may not be greater than :max characters.',
            'date_of_birth.required' => 'The date of birth field is required.',
            'date_of_birth.date' => 'The date of birth field must be a valid date.',
            'address.required' => 'The address field is required.',
            'address.string' => 'The address must be a string.',
            'gender_id.required' => 'The gender field is required.'
        ];
    }
}
