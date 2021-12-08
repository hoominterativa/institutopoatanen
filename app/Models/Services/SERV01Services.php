<?php

namespace App\Models\Services;

use Database\Factories\SERV01ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function getCategory()
    {
        return $this->belongsTo(SERV01ServicesCategories::class, 'category_id');
    }

    public function getSubcategory()
    {
        return $this->belongsTo(SERV01ServicesSubcategories::class, 'subcategory_id');
    }

    public function scopeSorting($query)
    {
        return $this->orderBy('sorting', 'ASC');
    }

    public function scopeFilterCategorySubcategory($query, $category, $subcategory=null)
    {
        if($category){
            return $this->where('category_id', $category->id);
        }
        if($subcategory){
            return $this->where(['category_id' => $category->id, 'subcategory_id' => $subcategory->id]);
        }
    }
}
