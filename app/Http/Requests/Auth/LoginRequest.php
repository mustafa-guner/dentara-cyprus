<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $username_or_email
 * @property string $password
 */
class LoginRequest extends FormRequest
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
        return [
            'username_or_email' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'username_or_email.required' => 'The username or email field is required.',
            'password.required' => 'The password field is required.',
        ];
    }

    /**
     * Customize the validation process.
     *
     * @param $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $this->validateUsernameOrEmail($validator);
        });
    }

    /**
     * Validate username or email.
     *
     * @param Validator $validator
     * @return void
     */
    protected function validateUsernameOrEmail(Validator $validator): void
    {
        $usernameOrEmail = $this->input('username_or_email');

        $validator->sometimes('username_or_email', 'exists:users,username', function () use ($usernameOrEmail) {
            return filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL) === false;
        });

        $validator->sometimes('username_or_email', 'exists:users,email', function () use ($usernameOrEmail) {
            return filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL) !== false;
        });

        $validator->after(function ($validator) use ($usernameOrEmail) {
            if ($validator->errors()->has('username_or_email')) {
                $validator->errors()->add('username_or_email', 'The username or email does not exist.');
            }
        });
    }
}
