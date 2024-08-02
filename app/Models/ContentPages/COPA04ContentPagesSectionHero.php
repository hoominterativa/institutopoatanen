<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA04ContentPagesSectionHeroFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA04ContentPagesSectionHero extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA04ContentPagesSectionHeroFactory::new();
    }

    protected $table = "copa04_contentpages_sectionheroes";
    protected $fillable = [
        'title',
        'description',
        'path_image',
        'path_logo',
        'path_icon',
        'color_one',
        'color_two',
        'color_three',
        'title_btn',
        'link',
        'active',
        'button_text',
        'button_link',
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
