<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT101PortfoliosGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT101PortfoliosGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT101PortfoliosGalleryFactory::new();
    }

    protected $table = "port101_portfolios_galleries";
    protected $fillable = ['path_image', 'path_video', 'sorting', 'portfolio_id'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
