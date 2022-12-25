<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Mp3File extends Model
{
    protected $table = 'mp3_files';
    protected $primaryKey = 'id';
    protected $fillable = ['filename_path', 'filename', 'title', 'artist', 'album', 'year', 'genre'];

    public $timestamps = false;
}
