<?php

namespace App\Models\ContentPages;

use Database\Factories\COPA04ContentPagesAdditionalContentImagesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA04ContentPagesAdditionalContentImages extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA04ContentPagesAdditionalContentImagesFactory::new();
    }

    protected $table = "copa04_contentpages_additionalcontentimages";
    protected $fillable = [
        'link_video',
        'path_image',
        'active',
        'sorting',
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
