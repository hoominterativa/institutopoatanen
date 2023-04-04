<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT101PortfoliosSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT101PortfoliosSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT101PortfoliosSectionFactory::new();
    }

    protected $table = "port101_portfolios_sections";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
