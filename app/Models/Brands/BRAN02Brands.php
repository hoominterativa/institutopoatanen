<?php

namespace App\Models\Brands;

use Database\Factories\Brands\BRAN02BrandsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BRAN02Brands extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BRAN02BrandsFactory::new();
    }

    protected $table = "bran02_brands";
    protected $fillable = [
        'title_home',
        'subtitle_home',
        'title_banner',
        'subtitle_banner',
        'title_page',
        'subtitle_page',
        'description',
        'button_link',
        'button_text',
        'target_link',
        'active',
        'sorting',
        'path_image',
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
