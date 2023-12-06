<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT03PortfoliosFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT03Portfolios extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT03PortfoliosFactory::new();
    }


    protected $table = "port03_portfolios";
    protected $fillable = [
        'category_id', 'title', 'slug', 'description', 'text', 'title_button', 'link_button', 'target_link_button', 'path_image_before', 'path_image_after', 'active', 'featured', 'sorting'
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

    public function category()
    {
        return $this->belongsTo(PORT03PortfoliosCategory::class, 'category_id');
    }
}
