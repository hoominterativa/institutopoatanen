<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV05ServicesCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV05ServicesCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV05ServicesCategoryFactory::new();
    }

    protected $table = "serv05_services_categories";
    protected $fillable = ['title', 'slug', 'path_image_icon', 'active', 'featured', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function scopeExists($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('serv05_services')->whereColumn('serv05_services.category_id', 'serv05_services_categories.id');
        });
    }

    // DROPDOW MENU
    public function scopeExistsRegister($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('serv05_services')->whereColumn('serv05_services.category_id', 'serv05_services_categories.id');
        });
    }
}
