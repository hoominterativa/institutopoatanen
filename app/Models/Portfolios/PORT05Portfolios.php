<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT05PortfoliosFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT05Portfolios extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT05PortfoliosFactory::new();
    }

    protected $table = "port05_portfolios";
    protected $fillable = [
        'slug',
        'title',
        'description',
        'path_image',
        'active',
        'featured',
        'title_banner',
        'path_image_desktop_banner',
        'path_image_mobile_banner',
        'active_banner',
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

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }

    public function galleries()
    {
        return $this->hasMany(PORT05PortfoliosGallery::class, 'portfolio_id')->sorting()->active();
    }

    public function testimonials()
    {
        return $this->hasMany(PORT05PortfoliosTestimonial::class, 'portfolio_id')->sorting()->active();
    }

    // public function categories()
    // {
    //     return $this->belongsToMany(PORT05PortfoliosCategory::class)->using(PORT05PortfoliosCategoryPortfolio::class);
    // }
}
