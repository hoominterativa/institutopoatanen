<?php

namespace App\Models\Services;

use App\Models\Services\SERV01Services;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\SERV01ServicesSubcategoriesFactory;

class SERV01ServicesSubcategories extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV01ServicesSubcategoriesFactory::new();
    }

    protected $table = "serv01_services_subcategories";

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeSorting($query)
    {
        return $this->orderBy('sorting', 'ASC');
    }

    public function scopeExistsService($query)
    {
        return $this->whereExists(function($query){
            $query->select(SERV01Services::raw('id'))
                ->from('serv01_services')
                ->whereRaw('serv01_services.subcategory_id = serv01_services_subcategories.id');
        });
    }

    public function getServices()
    {
        return $this->hasMany(SERV01Services::class, 'subcategory_id')->sorting();
    }
}
