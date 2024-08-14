<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT05PortfoliosGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT05PortfoliosGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT05PortfoliosGalleryFactory::new();
    }

    protected $table = "port05_portfolios_galleries";
    protected $fillable = [
        'portfolio_id',
        'link_video',
        'path_image',
        'featured',
        'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function portfolio()
    {
        return $this->belongsTo(PORT05Portfolios::class, 'portfolio_id');
    }
}
