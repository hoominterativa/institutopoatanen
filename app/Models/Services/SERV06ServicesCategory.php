<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV06ServicesCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV06ServicesCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV06ServicesCategoryFactory::new();
    }

    protected $table = "serv06_services_categories";
    protected $fillable = [ 'title', 'slug', 'slug','path_image_icon', 'active', 'sorting'];

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
            $query->select('id')->from('serv06_services')->whereColumn('serv06_services.category_id', 'serv06_services_categories.id');
        });
    }

    // DROPDOW MENU
    public function scopeExistsRegister($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('serv06_services')->whereColumn('serv06_services.category_id', 'serv06_services_categories.id');
        });
    }
}
