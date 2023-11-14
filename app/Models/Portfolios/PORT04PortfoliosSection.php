<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT04PortfoliosSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT04PortfoliosSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT04PortfoliosSectionFactory::new();
    }

    protected $table = "port04_portfolios_sections";
    protected $fillable = [
        //Section
        'title_section', 'subtitle_section', 'text_section', 'active_section',
        //Banner
        'title_banner', 'subtitle_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'background_color_banner', 'active_banner',
        //Content
        'title_content', 'subtitle_content', 'text_content', 'active_content',
        //Internal relationship
       'title_relationship', 'subtitle_relationship', 'description_relationship', 'active_relationship',
    ];

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

}
