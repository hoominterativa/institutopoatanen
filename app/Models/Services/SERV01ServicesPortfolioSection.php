<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\Services\SERV01ServicesPortfolioSectionFactory;

class SERV01ServicesPortfolioSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV01ServicesPortfolioSectionFactory::new();
    }

    protected $table = "serv01_services_portfoliosections";
    protected $fillable = [
        "title",
        "subtitle",
        "description",
        "active",
        "service_id",
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
