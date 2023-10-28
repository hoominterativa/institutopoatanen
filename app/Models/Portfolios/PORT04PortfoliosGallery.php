<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT04PortfoliosGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT04PortfoliosGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT04PortfoliosGalleryFactory::new();
    }

    protected $table = "port04_portfolios_galleries";
    protected $fillable = ['portfolio_id', 'path_image', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }
}
