<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV04ServicesCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV04ServicesCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV04ServicesCategoryFactory::new();
    }

    protected $table = "serv04_services_categories";
    protected $fillable = [
        'title', 'slug', 'slug', 'description', 'path_image', 'active', 'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeExists($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('serv04_services')->whereColumn('serv04_services.category_id', 'serv04_services_categories.id');
        });
    }

    // DROPDOW MENU
    public function scopeExistsRegister($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('serv04_services')->whereColumn('serv04_services.category_id', 'serv04_services_categories.id');
        });
    }
}
