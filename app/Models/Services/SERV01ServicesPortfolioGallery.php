<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\Services\SERV01ServicesPortfolioGalleryFactory;

class SERV01ServicesPortfolioGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV01ServicesPortfolioGalleryFactory::new();
    }

    protected $table = "serv01_services_portfoliogalleries";
    protected $fillable = [
        "path_image",
        "legend",
        "sorting",
        "portfolio_id",
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }
}
