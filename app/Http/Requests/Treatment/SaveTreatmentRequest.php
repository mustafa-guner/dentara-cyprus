<?php

namespace App\Http\Requests\Treatment;

use Illuminate\Foundation\Http\FormRequest;

class SaveTreatmentRequest extends FormRequest
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
            'treatment_type_id' => 'required|exists:treatment_types,id',
            'equipment_id' => 'nullable|exists:equipments,id',
            'comments' => 'nullable|string',
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
            'treatment_type_id.required' => 'Treatment type field is required.',
            'treatment_type_id.exists' => 'Please enter a valid treatment type.',
            'equipment_id.exists' => 'Please enter a valid equipment.',
            'comments.string' => 'The comments must be a string.',
        ];
    }
}
