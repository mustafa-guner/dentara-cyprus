<?php

namespace App\Models\Appointment;

use App\Models\Discount;
use App\Models\Patient;
use App\Models\Payment\PaymentMethod;
use App\Models\Payment\PaymentStatus;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $appointment_date
 * @property int $patient_id
 * @property int $assigned_user_id
 * @property int $appointment_status_id
 * @property int $appointment_type_id
 * @property int $payment_method_id
 * @property int $payment_status_id
 * @property int $discount_id
 * @property string $comment
 * @property float $price
 * @property float $real_price
 * @property int $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 *
 * @property AppointmentStatus $appointmentStatus
 * @property AppointmentType $appointmentType
 * @property PaymentStatus $paymentStatus
 * @property PaymentMethod $paymentMethod
 * @property User $user
 * @property Patient $patient
 * @property Discount $discount
 * @property AppointmentTreatments[] $treatments
 * @property mixed $calculateTotalPrice
 */
class Appointment extends Model
{
    use HasFactory;

    protected $casts = [
        'price' => 'float',
        'real_price' => 'float',
    ];

    protected $fillable = [
        'appointment_date',
        'patient_id',
        'assigned_user_id',
        'appointment_status_id',
        'payment_method_id',
        'payment_status_id',
        'appointment_type_id',
        'discount_id',
        'comment',
        'price',
        'real_price',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function appointmentStatus(): BelongsTo
    {
        return $this->belongsTo(AppointmentStatus::class, 'appointment_status_id');
    }

    public function appointmentType(): BelongsTo
    {
        return $this->belongsTo(AppointmentType::class, 'appointment_type_id');
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function paymentStatus(): BelongsTo
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    public function treatments(): HasMany
    {
        return $this->hasMany(AppointmentTreatments::class, 'appointment_id')->with(['treatment','user']);
    }
    
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function calculateTotalPrice(): float|int|string
    {
        $appointmentTypePrice = (float)$this->appointmentType->price;
        $discountAmount = $this->discount ? $this->discount->percentage : 0;

        $treatmentSum = 0;

        $appointmentTreatments = $this->treatments();

        foreach ($appointmentTreatments as $appointmentTreatment) {
            $treatmentSum += (float)$appointmentTreatment->treatment->price;
        }

        $discountedPrice = $treatmentSum + $appointmentTypePrice - ($appointmentTypePrice * $discountAmount / 100);
        $priceWithoutDiscount = $treatmentSum + $appointmentTypePrice;

        $price = $appointmentTypePrice - ($appointmentTypePrice * $discountAmount / 100);

        $this->price = $discountedPrice;
        $this->real_price = $priceWithoutDiscount;
        $this->save();

        return $price;
    }


}
