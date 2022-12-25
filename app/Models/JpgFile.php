<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class JpgFile extends Model
{
    protected $table = 'jpg_files';
    protected $primaryKey = 'id';
    protected $fillable = ['filename_path', 'filename', 'title', 'tags', 'comments', 'date', 'has_exif_metadata'];

    public $timestamps = false;
}
