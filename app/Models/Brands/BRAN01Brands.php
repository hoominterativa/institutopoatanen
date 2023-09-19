<?php

namespace App\Models\Brands;

use Database\Factories\Brands\BRAN01BrandsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BRAN01Brands extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BRAN01BrandsFactory::new();
    }

    protected $table = "bran01_brands";
    protected $fillable = [
        'link', 'target_link', 'path_image_icon', 'path_image_box', 'active', 'featured', 'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }
}
