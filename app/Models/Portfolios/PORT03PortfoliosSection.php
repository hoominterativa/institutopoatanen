<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT03PortfoliosSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT03PortfoliosSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT03PortfoliosSectionFactory::new();
    }

    protected $table = "port03_portfolios_sections";
    protected $fillable = [
        //Section page
        'title_section', 'subtitle_section', 'active_section',
        //Banner home
        'title_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'background_color_banner', 'active_banner',
        //Content page
        'title_content', 'subtitle_content', 'active_content', 'description_content', 'path_image_icon_content'
    ];

    public function scopeActive($query)
    {
        return $query->where('active_section', 1);
    }

}
