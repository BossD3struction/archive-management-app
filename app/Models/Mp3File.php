<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mp3File extends Model
{
    use HasFactory;

    protected $table = 'mp3_files';
    protected $primaryKey = 'id';
    protected $fillable = ['filename_path', 'filename', 'title', 'artist', 'album', 'year', 'genre'];

    public $timestamps = false;
}
