<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA04ContentPagesSectionVideoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA04ContentPagesSectionVideo extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA04ContentPagesSectionVideoFactory::new();
    }

    protected $table = "copa04_contentpages_sectionvideos";
    protected $fillable = [
        'title',
        'subtitle',
        'text',
        'color_one',
        'link',
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
