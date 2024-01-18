<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV10ServicesCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV10ServicesCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV10ServicesCategoryFactory::new();
    }

    protected $table = "serv10_services_categories";
    protected $fillable = ['slug', 'title', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeExists($query){
        return $query->whereExists(function($query){
            $query->select('id')->from('serv10_services')->whereColumn('serv10_services.category_id', 'serv10_services_categories.id');
        });
    }

    // DROPDOW MENU

    public function scopeExistsRegister($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('serv10_services')->whereColumn('serv10_services.category_id', 'serv10_services_categories.id');
        });
    }
}
