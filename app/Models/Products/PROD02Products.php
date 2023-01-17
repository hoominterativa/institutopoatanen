<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\Products\PROD02ProductsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PROD02Products extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD02ProductsFactory::new();
    }

    protected $table = "prod02_products";
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
