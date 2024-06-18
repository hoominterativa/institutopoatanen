<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT05PortfoliosSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT05PortfoliosSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT05PortfoliosSectionFactory::new();
    }

    protected $table = "port05_portfolios_sections";
    protected $fillable = [
        'title_section',
        'subtitle_section',
        'active_section',
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

    public function scopeActiveSection($query)
    {
        return $query->where('active_section', 1);
    }

    public function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }
}
