<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\Services\SERV01ServicesPortfolioFactory;

class SERV01ServicesPortfolio extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV01ServicesPortfolioFactory::new();
    }

    protected $table = "serv01_services_portfolios";
    protected $fillable = [
        "title",
        "description",
        "active",
        "sorting",
        "path_image",
        "service_id",
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function gallery()
    {
        return $this->hasMany(SERV01ServicesPortfolioGallery::class, 'portfolio_id')->sorting();
    }
}
