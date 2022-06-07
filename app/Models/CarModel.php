<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class CarModel extends Model
{
    use HasFactory;

    protected $table = 'car_models';
    protected $primaryKey = 'id';

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function productionDate(): HasOneThrough
    {
        return $this->hasOneThrough(
            CarProductionDate::class,
            CarModel::class,
            'id',
            'model_id'
        );
    }
}
