<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA04ContentPagesgalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
