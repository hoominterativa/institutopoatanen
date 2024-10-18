<?php

namespace App\Models\Brands;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BRAN02BrandsMarcas extends Model
{


    protected $table = "bran02_brands_marcas";
    protected $fillable = [
        'category_id',
        'name',
        'path_image',
        'highlighted',
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
    public function scopeHighlighted($query)
    {
        return $query->where('highlighted', 1);
    }
    public function category()
    {
        return $this->belongsTo(BRAN02BrandsCategories::class, 'category_id');
    }


    // public function getRelationCore()
    // {
    //     return null;
    // }
}
