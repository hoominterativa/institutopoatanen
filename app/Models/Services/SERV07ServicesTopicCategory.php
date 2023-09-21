<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV07ServicesTopicCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV07ServicesTopicCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV07ServicesTopicCategoryFactory::new();
    }

    protected $table = "serv07_services_topiccategories";
    protected $fillable = ['category_id', 'title', 'description', 'path_image', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function category()
    {
        return $this->belongsTo(SERV07ServicesCategory::class, 'category_id');
    }
}
