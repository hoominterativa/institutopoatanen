<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT03PortfoliosCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT03PortfoliosCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT03PortfoliosCategoryFactory::new();
    }

    protected $table = "port03_portfolios_categories";
    protected $fillable = ['title', 'slug', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeExists($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('port03_portfolios')->whereColumn('port03_portfolios.category_id', 'port03_portfolios_categories.id');
        });
    }
}
