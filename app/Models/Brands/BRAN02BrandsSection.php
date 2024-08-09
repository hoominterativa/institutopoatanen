<?php

namespace App\Models\Brands;

use Database\Factories\Brands\BRAN02BrandsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BRAN02BrandsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BRAN02BrandsSectionFactory::new();
    }

    protected $table = "bran02_brands_sections";
    protected $fillable = [
        'category',
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
    public function BrandsProducts()
    {
        return $this->hasMany(BRAN02BrandsProducts::class, 'category_id')->exists()->active()->sorting();;
    }
    // public function getRelationCore()
    // {
    //     return null;
    // }
}
