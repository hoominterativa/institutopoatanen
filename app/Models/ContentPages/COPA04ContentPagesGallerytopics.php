<?php

namespace App\Models\ContentPages;

use Database\Factories\COPA04ContentPagesGallerytopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA04ContentPagesGallerytopics extends Model
{
    use HasFactory, SoftDeletes;

    protected static function newFactory()
    {
        return COPA04ContentPagesGallerytopicsFactory::new();
    }

    protected $table = "copa04_contentpages_gallerytopics";
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'path_image',
        'link_video',
        'sorting',
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
