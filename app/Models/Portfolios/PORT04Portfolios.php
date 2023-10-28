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
        //Portfolio
       'category_id', 'slug', 'title', 'description', 'path_image', 'path_image_icon', 'active', 'featured',
       //Internal Banner
       'title_banner', 'subtitle_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'background_color_banner', 'active_banner',
       //Internal Content
       'title_content', 'subtitle_content', 'text_content', 'path_image_content', 'active_content',
       //Internal Section
       'title_section', 'subtitle_section', 'description_section', 'active_section',
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

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }

    public function scopeActiveContent($query)
    {
        return $query->where('active_content', 1);
    }

    public function scopeActiveSection($query)
    {
        return $query->where('active_section', 1);
    }

    public function additionalTopics()
    {
        return $this->hasMany(PORT04PortfoliosAdditionalTopic::class, 'portfolio_id');
    }

    public function topics()
    {
        return $this->hasMany(PORT04PortfoliosTopic::class, 'portfolio_id');
    }

    public function galleries()
    {
        return $this->hasMany(PORT04PortfoliosGallery::class, 'portfolio_id');
    }

    public function category()
    {
        return $this->belongsTo(PORT04PortfoliosCategory::class, 'category_id');
    }
}
