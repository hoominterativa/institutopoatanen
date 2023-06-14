<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;

    protected $table = 'social';
    protected $fillable = ['title', 'link', 'path_image_icon', 'sorting'];

    public function scopeSorting()
    {
        return $this->orderBy('sorting', 'ASC');
    }
}
