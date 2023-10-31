<?php

namespace App\Models\Galleries;

use Database\Factories\Galleries\GALL01GalleriesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GALL01Galleries extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return GALL01GalleriesFactory::new();
    }

    protected $table = "gall01_galleries";
    protected $fillable = ['path_image', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }
}
