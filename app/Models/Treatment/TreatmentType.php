<?php

namespace App\Models\Treatment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $price
 * @property string $created_at
 * @property string|null $updated_at
 */
class TreatmentType extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description'
    ];
}
