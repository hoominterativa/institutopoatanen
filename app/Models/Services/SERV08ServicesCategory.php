<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV08ServicesCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV08ServicesCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV08ServicesCategoryFactory::new();
    }

    protected $table = "serv08_services_categories";
    protected $fillable = ['slug', 'title', 'path_image', 'active', 'featured', 'sorting'];

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

    public function scopeExists($query){
        return $query->whereExists(function($query){
            $query->select('id')->from('serv08_services')->whereColumn('serv08_services.category_id', 'serv08_services_categories.id');
        });
    }
}
