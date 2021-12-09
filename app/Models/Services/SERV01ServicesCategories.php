<?php

namespace App\Models\Services;

use App\Models\Services\SERV01Services;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\SERV01ServicesCategoriesFactory;

class SERV01ServicesCategories extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV01ServicesCategoriesFactory::new();
    }

    protected $table = "serv01_services_categories";

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeExistsService($query)
    {
        return $query->whereExists(function($query){
            $query->select(SERV01Services::raw('id'))
                ->from('serv01_services')
                ->whereRaw('serv01_services.category_id = serv01_services_categories.id');
        });
    }

    public function subcategories()
    {
        return $this->belongsToMany(SERV01ServicesSubcategories::class, 'serv01_services', 'category_id', 'subcategory_id')->sorting()->existsService()->groupBy('pivot_subcategory_id','pivot_category_id');
    }

    public function services()
    {
        return $this->hasMany(SERV01Services::class, 'category_id')->with('subcategories');
    }
}
