<?php

namespace App\Models\Appointment;

use App\Models\Treatment\Treatment;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $appointment_id
 * @property int $treatment_id
 * @property int $user_id
 * @property string $created_at
 * @property string|null $updated_at
 */
class AppointmentTreatments extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'treatment_id',
        'user_id',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class, 'treatment_id');
    }
}
