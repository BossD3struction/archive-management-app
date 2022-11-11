<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(string $string, mixed $filenamePath)
 * @method static find(int $id)
 * @method static count()
 */
class JpgFile extends Model
{
    use HasFactory;

    protected $table = 'jpg_files';
    protected $primaryKey = 'id';
    protected $fillable = ['filename_path', 'filename', 'title', 'tags', 'comments', 'date', 'has_exif_metadata'];

    public $timestamps = false;
}
