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

    protected $table = "brand01_brands";
    protected $fillable = [];

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
