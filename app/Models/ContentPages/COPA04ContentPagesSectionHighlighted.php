<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA04ContentPagesSectionHighlightedFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA04ContentPagesSectionHighlighted extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA04ContentPagesSectionHighlightedFactory::new();
    }

    protected $table = "copa04_contentpages_sectionhighlighteds";
    protected $fillable = [
        'title',
        'subtitle',
        'text',
        'link',
        'color_one',
        'btn_title',
        'path_image',
        'active',
        'sorting'
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
