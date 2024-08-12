<?php

namespace App\Models\Brands;

use Database\Factories\Brands\BRAN02BrandsproductsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BRAN02Brandsproducts extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BRAN02BrandsproductsFactory::new();
    }

    protected $table = "bran02_brands_products";
    protected $fillable = [
        'category_id',
        'name',
        'path_image',
        'button_text',
        'button_link',
        'target_link',
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

    public function category()
    {
        return $this->belongsTo(BRAN02BrandsSection::class, 'category_id');
    }


    // public function getRelationCore()
    // {
    //     return null;
    // }
}
