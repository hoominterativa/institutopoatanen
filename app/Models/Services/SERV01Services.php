<?php

namespace App\Models\Services;

use Database\Factories\SERV01ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SERV01Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV01ServicesFactory::new();
    }

    protected $table = "serv01_services";

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(SERV01ServicesCategories::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SERV01ServicesSubcategories::class, 'subcategory_id');
    }

    public function categories()
    {
        return $this->belongsToMany(SERV01ServicesCategories::class, 'category_id')->scopeExistsService();
    }

    public function subcategories()
    {
        return $this->belongsToMany(SERV01ServicesSubcategories::class, 'subcategory_id')->scopeExistsService();
    }

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeFilterCategorySubcategory($query, $category, $subcategory=null)
    {
        if($category && !$subcategory){
            return $query->where('category_id', $category->id);
        }
        if($subcategory){
            return $query->where(['category_id' => $category->id, 'subcategory_id' => $subcategory->id]);
        }
    }
}
