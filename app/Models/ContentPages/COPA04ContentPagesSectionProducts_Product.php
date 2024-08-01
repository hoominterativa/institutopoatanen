<?php

namespace App\Models\ContentPages;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\ContentPages\COPA04ContentPagesSectionProducts_ProductFactory;

class COPA04ContentPagesSectionProducts_Product extends Model
{
    use HasFactory, SoftDeletes;

    protected static function newFactory()
    {
        return COPA04ContentPagesSectionProducts_ProductFactory::new();
    }

    protected $table = "copa04_contentpages_sectionproducts_products";
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'value_text',
        'value',
        'button_text',
        'button_link',
        'promotion',
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

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
