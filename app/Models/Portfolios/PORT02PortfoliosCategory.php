<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT02PortfoliosCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT02PortfoliosCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT02PortfoliosCategoryFactory::new();
    }

    protected $table = "port02_portfolios_categories";
    protected $fillable = ['title', 'slug', 'path_image_icon', 'active', 'featured', 'sorting'];

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

    public function scopeExists($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('port02_portfolios')->whereColumn('port02_portfolios.category_id', 'port02_portfolios_categories.id');
        });
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
