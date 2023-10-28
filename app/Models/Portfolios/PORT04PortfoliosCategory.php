<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT04PortfoliosCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT04PortfoliosCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT04PortfoliosCategoryFactory::new();
    }

    protected $table = "port04_portfolios_categories";
    protected $fillable = [
        'slug', 'title', 'path_image', 'active', 'sorting'
    ];

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
            $query->select('id')->from('port04_portfolios')->whereColumn('port04_portfolios.category_id', 'port04_portfolios_categories.id');
        });
    }

}
