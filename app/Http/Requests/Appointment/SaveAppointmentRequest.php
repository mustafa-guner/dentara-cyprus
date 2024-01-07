<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $appointment_date
 * @property integer $patient_id
 * @property integer $assigned_user_id
 * @property integer $appointment_status_id
 * @property integer $payment_method_id
 * @property integer $payment_status_id
 * @property integer $appointment_type_id
 * @property integer $discount_id
 * @property string $comment
 * @property integer $price
 * @property integer $real_price
 */
class SaveAppointmentRequest extends FormRequest
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
            'appointment_date' => 'required|date',
            'patient_id' => 'required|exists:patients,id',
            'assigned_user_id' => 'required|exists:users,id',
            'appointment_status_id' => 'required|exists:appointment_statuses,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'payment_status_id' => 'required|exists:payment_statuses,id',
            'appointment_type_id' => 'required|exists:appointment_types,id',
            'discount_id' => 'required|exists:discounts,id',
            'comment' => 'nullable|string',
            'price' => 'required|numeric',
            'real_price' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'appointment_date.required' => 'The appointment date field is required.',
            'patient_id.required' => 'The patient field is required.',
            'assigned_user_id.required' => 'The assigned user field is required.',
            'appointment_status_id.required' => 'The appointment status field is required.',
            'payment_method_id.required' => 'The payment method field is required.',
            'payment_status_id.required' => 'The payment status field is required.',
            'appointment_type_id.required' => 'The appointment type field is required.',
            'discount_id.required' => 'The discount field is required.',
            'price.required' => 'The price field is required.',
            'real_price.required' => 'The real price field is required.',
        ];
    }
}
