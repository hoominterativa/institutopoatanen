<?php

namespace App\Models\Products;

use Database\Factories\Products\PROD05ProductsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PROD05ProductsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD05ProductsSectionFactory::new();
    }

    protected $table = "prod05_products_sections";
    protected $fillable = [
        "title",
        "subtitle",
        "description",
        "title_banner",
        "subtitle_banner",
        "path_image_banner",
        "active",
        "sorting",
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
