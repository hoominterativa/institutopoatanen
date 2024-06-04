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
    protected $fillable = ['slug', 'title', 'text', 'path_image', 'active', 'featured', 'sorting'];

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

    public function services()
    {
        return $this->hasMany(SERV12Services::class, 'category_id')->active()->sorting();
    }
}
