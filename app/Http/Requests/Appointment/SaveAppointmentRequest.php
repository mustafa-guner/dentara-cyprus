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
 * @property array $treatments
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
        $appointment_id = $this->route('id');

        return [
            'appointment_date' => 'required|date|unique:appointments,appointment_date,' . $appointment_id . ',id,deleted_at,NULL',
            'patient_id' => 'required|exists:patients,id',
            'assigned_user_id' => 'required|exists:users,id',
            'appointment_status_id' => 'required|exists:appointment_statuses,id',
            'payment_method_id' => $appointment_id ? 'required|exists:payment_methods,id' : 'nullable',
            'payment_status_id' => 'required|exists:payment_statuses,id',
            'appointment_type_id' => 'required|exists:appointment_types,id',
            'discount_id' => 'nullable|exists:discounts,id',
            'comment' => 'nullable|string',

            //Optional fields for appointment treatments on end of the appointment
            'treatments' => 'nullable|array',
            'treatments.*.treatment_id' => 'nullable|exists:treatments,id',
            'treatments.*.responsible_user_id' => 'nullable|exists:users,id'
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
            'appointment_date.date' => 'The appointment date must be a date.',
            'appointment_date.unique' => 'The appointment date has already been taken.',
            'patient_id.exists' => 'Please enter a valid patient.',
            'assigned_user_id.exists' => 'Please enter a valid assigned user.',
            'appointment_status_id.exists' => 'Please enter a valid appointment status.',
            'payment_method_id.exists' => 'Please enter a valid payment method.',
            'payment_status_id.exists' => 'Please enter a valid payment status.',
            'appointment_type_id.exists' => 'Please enter a valid appointment type.',
            'discount_id.exists' => 'Please enter a valid discount.',
            'comment.string' => 'The comment must be a string.',
            'treatments.array' => 'The treatments must be an array.',
            'treatments.*.treatment_id.exists' => 'Please enter a valid treatment.',
            'treatments.*.responsible_user_id.exists' => 'Please enter a valid responsible user.',
        ];
    }
}
