<?php

namespace App\Models\ContentPages;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\ContentPages\COPA04ContentPagesgalleryFactory;

class COPA04ContentPagesgallery extends Model
{
    use HasFactory, SoftDeletes;

    protected static function newFactory()
    {
        return COPA04ContentPagesgalleryFactory::new();
    }

    protected $table = "copa04_contentpages_galleries";
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'color_one',
        'active',
    ];

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
