<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV07ServicesSectionCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV07ServicesSectionCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV07ServicesSectionCategoryFactory::new();
    }

    protected $table = "serv07_services_sectioncategories";
    protected $fillable = [
        'category_id',
        'title',
        'subtitle',
        'description',
        'path_image',
        'title_button',
        'link_button',
        'target_link_button',
        'active',
        'sorting',
    ];

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
