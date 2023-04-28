<?php

namespace App\Models\Products;

use Database\Factories\Products\PROD02ProductsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PROD02ProductsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD02ProductsSectionFactory::new();
    }

    protected $table = "prod02_products_sections";
    protected $fillable = ['title', 'description', 'subtitle', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
