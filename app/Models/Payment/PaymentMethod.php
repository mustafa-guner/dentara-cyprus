<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $definition
 * @property string $created_at
 * @property string|null $updated_at
 */
class PaymentMethod extends Model
{
    use HasFactory;
    protected $fillable = [
        'definition',
    ];
}
