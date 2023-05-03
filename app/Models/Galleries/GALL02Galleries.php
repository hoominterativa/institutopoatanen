<?php

namespace App\Models\Galleries;

use Database\Factories\Galleries\GALL02GalleriesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GALL02Galleries extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return GALL02GalleriesFactory::new();
    }

    protected $table = "gall02_galleries";
    protected $fillable = [];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
