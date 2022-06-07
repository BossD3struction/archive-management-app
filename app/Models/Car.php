<?php /** @noinspection PhpUnused */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'founded', 'description', 'image_path'];
    protected $hidden = ['updated_at'];

    public function carModels(): HasMany
    {
        return $this->hasMany(CarModel::class);
    }

    public function engines(): HasManyThrough
    {
        return $this->hasManyThrough(
            Engine::class,
            CarModel::class,
            'car_id',
            'model_id'
        );
    }

    /*public function productionDate(): HasOneThrough
    {
        return $this->hasOneThrough(
            CarProductionDate::class,
            CarModel::class,
            'id',
            'model_id'
        );
    }*/

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

}
