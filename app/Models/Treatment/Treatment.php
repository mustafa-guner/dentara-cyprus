<?php

namespace App\Models\Treatment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $comment
 * @property int $equipment_id
 */
class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'equipment_id',
        'treatment_type_id'
    ];

    public function treatmentType(): BelongsTo
    {
        return $this->belongsTo(TreatmentType::class, 'treatment_type_id');
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
}
