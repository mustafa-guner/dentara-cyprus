<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $definition
 * @property float $percentage
 * @property string $created_at
 * @property string|null $updated_at
 */
class Discount extends Model
{
    use HasFactory;

    protected $casts = [
        'percentage' => 'float',
    ];

    protected $fillable = [
        'definition',
        'percentage'
    ];
}
