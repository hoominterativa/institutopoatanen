<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV07ServicesCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV07ServicesCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV07ServicesCategoryFactory::new();
    }

    protected $table = "serv07_services_categories";
    protected $fillable = ['title', 'subtitle', 'description', 'slug', 'path_image', 'path_image_icon', 'active', 'sorting', 'featured', 'title_button', 'link_button', 'target_link_button',];

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
            $query->select('id')->from('serv07_services')->whereColumn('serv07_services.category_id', 'serv07_services_categories.id');
        });
    }

    // DROPDOW MENU
    public function scopeExistsRegister($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('serv07_services')->whereColumn('serv07_services.category_id', 'serv07_services_categories.id');
        });
    }

    public function section()
    {
        return $this->hasMany(SERV07ServicesSectionCategory::class, 'category_id');
    }

    public function video()
    {
        return $this->hasMany(SERV07ServicesVideo::class, 'category_id');
    }

    public function gallery()
    {
        return $this->hasMany(SERV07ServicesVideo::class, 'category_id');
    }
}
