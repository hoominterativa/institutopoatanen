<?php

namespace App\Models\Products;

use Database\Factories\Products\PROD05ProductsTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PROD05ProductsTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD05ProductsTopicFactory::new();
    }

    protected $table = "prod05_products_topics";
    protected $fillable = [
        'category_id',
        'title',
        'text',
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
