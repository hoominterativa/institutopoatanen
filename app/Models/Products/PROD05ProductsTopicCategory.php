<?php

namespace App\Models\Products;

use Database\Factories\Products\PROD05ProductsTopicCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PROD05ProductsTopicCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PROD05ProductsTopicCategoryFactory::new();
    }

    protected $table = "prod05_products_topiccategories";
    protected $fillable = [
        "product_id",
        "title",
        "path_image_icon",
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

    public function topics()
    {
        return $this->hasMany(PROD05ProductsTopic::class, 'category_id', 'id');
    }

    public function scopeExists($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('prod05_products_topics')->whereColumn('prod05_products_topics.category_id', 'prod05_products_topiccategories.id');
        });
    }

    public function scopeExistsRegister($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('prod05_products_topics')->whereColumn('prod05_products_topics.category_id', 'prod05_products_topiccategories.id');
        });
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
