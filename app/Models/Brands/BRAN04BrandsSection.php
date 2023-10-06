<?php

namespace App\Models\Brands;

use Database\Factories\Brands\BRAN04BrandsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BRAN04BrandsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BRAN04BrandsSectionFactory::new();
    }

    protected $table = "bran04_brands_sections";
    protected $fillable = ['title', 'description', 'subtitle', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
