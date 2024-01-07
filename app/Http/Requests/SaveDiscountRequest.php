<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $definition
 * @property float $percentage
 */
class SaveDiscountRequest extends FormRequest
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
            'definition' => 'required|string|max:100',
            'percentage' => 'required|numeric|between:0,100',
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
            'definition.required' => 'The definition field is required.',
            'definition.string' => 'The definition must be a string.',
            'definition.max' => 'The definition may not be greater than :max characters.',
            'percentage.required' => 'The percentage field is required.',
            'percentage.numeric' => 'The percentage must be a number.',
            'percentage.between' => 'The percentage must be between :min and :max.',
        ];
    }
}
