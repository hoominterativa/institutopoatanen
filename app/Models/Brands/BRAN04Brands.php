<?php

namespace App\Models\Brands;

use Database\Factories\Brands\BRAN04BrandsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BRAN04Brands extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BRAN04BrandsFactory::new();
    }

    protected $table = "bran04_brands";
    protected $fillable = ['path_image', 'path_image_icon', 'link', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
