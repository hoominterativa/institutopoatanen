<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT02PortfoliosBannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT02PortfoliosBanner extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT02PortfoliosBannerFactory::new();
    }

    protected $table = "port02_portfolios_banners";
    protected $fillable = ['title', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
