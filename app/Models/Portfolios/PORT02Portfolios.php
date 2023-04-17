<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT02PortfoliosFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT02Portfolios extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT02PortfoliosFactory::new();
    }

    protected $table = "port02_portfolios";
    protected $fillable = ['title', 'slug', 'path_image_box', 'active', 'featured', 'sorting'];

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

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
