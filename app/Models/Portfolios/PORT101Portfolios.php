<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT101PortfoliosFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Portfolios\PORT101PortfoliosGallery;

class PORT101Portfolios extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT101PortfoliosFactory::new();
    }

    protected $table = "port101_portfolios";
    protected $fillable = ['title', 'subtitle', 'description', 'link_button', 'target_link_button', 'colors', 'path_image_box', 'path_image_desktop', 'path_image_moblie', 'featured', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1)->where('featured', 1);
    }

    public function galleries()
    {
        return $this->hasMany(PORT101PortfoliosGallery::class, 'portfolio_id');
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
