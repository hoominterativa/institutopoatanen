<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV01ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV01Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV01ServicesFactory::new();
    }

    protected $table = "serv01_services";
    protected $fillable = [
        "title",
        "subtitle",
        "description",
        "text",
        "active",
        "featured",
        "sorting",
        "path_image",
        "path_image_icon",
        "path_image_banner",
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

    public function advantages()
    {
        return $this->hasMany(SERV01ServicesAdvantage::class, 'service_id')->active()->sorting();
    }

    public function advantagesSection()
    {
        return $this->hasOne(SERV01ServicesAdvantageSection::class, 'service_id');
    }

    public function portfolios()
    {
        return $this->hasMany(SERV01ServicesPortfolio::class, 'service_id')->with('gallery')->active()->sorting();
    }

    public function portfoliosSection()
    {
        return $this->hasOne(SERV01ServicesPortfolioSection::class, 'service_id');
    }
}
