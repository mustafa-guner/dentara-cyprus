<?php

namespace App\Models\Appointment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $price
 * @property string $created_at
 * @property string|null $updated_at
 */
class AppointmentType extends Model
{
    use HasFactory;

    protected $casts = [
        'price' => 'integer'
    ];

    protected $fillable = [
        'title',
        'description',
        'price'
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
