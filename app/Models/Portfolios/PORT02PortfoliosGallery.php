<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT02PortfoliosGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT02PortfoliosGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT02PortfoliosGalleryFactory::new();
    }

    protected $table = "port02_portfolios_galleries";
    protected $fillable = ['path_image', 'link_video', 'sorting', 'portfolio_id'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

}
