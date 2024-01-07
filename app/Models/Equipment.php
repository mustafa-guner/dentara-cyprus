<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $definition
 * @property int $quantity
 * @property string $created_at
 * @property string|null $updated_at
 */
class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    protected $fillable = [
        'definition',
        'quantity'
    ];
}
