<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $definition
 * @property string $created_at
 * @property string|null $updated_at
 */
class Gender extends Model
{
    use HasFactory;

    protected $fillable = [
        'definition',
    ];

    protected $appends = ['definition'];

    public function getDefinitionAttribute()
    {
        return $this->attributes['definition'];
    }
}
