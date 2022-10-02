<?php

namespace App\Models\Portfolios;

use Database\Factories\PORT01GalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT01PortfoliosGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT01GalleryFactory::new();
    }

    protected $table = "port01_portfolios_galleries";
    protected $fillable = ["path_image","portfolio_id","sorting"];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }
}
