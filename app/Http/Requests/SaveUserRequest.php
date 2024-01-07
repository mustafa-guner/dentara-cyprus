<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $phone_no
 * @property string $date_of_birth
 * @property int $gender_id
 * @property int $role_id
 * @property int $user_type_id
 * @property string $password
 * @property string $password_confirmation
 */
class SaveUserRequest extends FormRequest
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
        $userID = $this->route('id');

        return [
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $userID,
            'phone_no' => 'required|string|max:50|unique:users,phone_no,' . $userID,
            'date_of_birth' => 'required|date',
            'gender_id' => 'required|exists:genders,id',
            'role_id' => 'required|exists:roles,id',
            'user_type_id' => 'required|exists:user_types,id',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'firstname.required' => 'The firstname field is required.',
            'lastname.required' => 'The lastname field is required.',
            'email.required' => 'The email field is required.',
            'phone_no.required' => 'The phone_no field is required.',
            'date_of_birth.required' => 'Date of birth field is required',
            'gender_id.required' => 'Gender field is required',
            'role_id.required' => 'Role field is required',
            'user_type_id.required' => 'User type field is required',
            'email.unique' => 'The email has already been taken.',
            'phone_no.unique' => 'The phone number has already been taken.',
            'gender_id.exists' => 'Please enter a valid gender.',
            'role_id.exists' => 'Please enter a valid role.',
            'user_type_id.exists' => 'Please enter a valid user type.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
