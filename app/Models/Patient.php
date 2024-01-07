<?php

namespace App\Models;

use App\Models\Appointment\Appointment;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $phone_no
 * @property string|null $date_of_birth
 * @property string|null $address
 * @property int|null $gender_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Gender $gender
 * @property User $createdBy
 * @property User $updatedBy
 * @property User $deletedBy
 */
class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'phone_no',
        'date_of_birth',
        'address',
        'gender_id',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
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
}
