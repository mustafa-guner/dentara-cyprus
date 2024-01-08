<?php

namespace App\Http\Requests\Treatment;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $treatment_type_id
 * @property int $equipment_id
 * @property string $comment
 */
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
            'comment' => 'nullable|string|max:300',
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
            'comment.string' => 'The comments must be a string.',
            'comment.max' => 'The comments may not be greater than 300 characters.'
        ];
    }
}
