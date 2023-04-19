<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT02PortfoliosBannerHomeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT02PortfoliosBannerHome extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT02PortfoliosBannerHomeFactory::new();
    }

    protected $table = "port02_portfolios_bannerhomes";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
