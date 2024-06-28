<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV12ServicesCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV12ServicesCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV12ServicesCategoryFactory::new();
    }

    protected $table = "serv12_services_categories";
    protected $fillable = [
        //Categories
        'slug', 'title', 'text', 'path_image', 'active', 'featured',
        //Banner
        'title_banner', 'subtitle_banner','path_image_desktop_banner', 'path_image_mobile_banner', 'active_banner',
        //General
        'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function services()
    {
        return $this->hasMany(SERV12Services::class, 'category_id')->active()->sorting();
    }

    public function sERV12Services()
    {
        return $this->hasMany(SERV12Services::class, 'category_id')->active()->sorting();
    }

    public function scopeExists($query){
        return $query->whereExists(function($query){
            $query->select('id')->from('serv12_services')->whereColumn('serv12_services.category_id', 'serv12_services_categories.id');
        });
    }

    // DROPDOW MENU

    public function scopeExistsRegister($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('serv12_services')->whereColumn('serv12_services.category_id', 'serv12_services_categories.id');
        });
    }
}
