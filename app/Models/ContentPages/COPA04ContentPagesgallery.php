<?php

namespace App\Models\ContentPages;

use Database\Factories\COPA04ContentPagesgalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA04ContentPagesgallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA04ContentPagesgalleryFactory::new();
    }

    protected $table = "";
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
