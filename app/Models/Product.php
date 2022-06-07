<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static find(int $id)
 */
class Product extends Model
{
    use HasFactory;

    public function cars(): BelongsToMany
    {
        return $this->belongsToMany(Car::class);
    }
}
