<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT04PortfoliosFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT04Portfolios extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT04PortfoliosFactory::new();
    }

    protected $table = "port04_portfolios";
    protected $fillable = [
       'category_id', 'slug', 'title', 'subtitle', 'text', 'path_image', 'title_box', 'description_box', 'path_image_box', 'path_image_icon_box', 'active', 'featured', 'sorting'
    ];

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
}
