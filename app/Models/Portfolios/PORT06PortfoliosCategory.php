<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT06PortfoliosCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT06PortfoliosCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT06PortfoliosCategoryFactory::new();
    }

    protected $table = "port06_portfolios_categories";
    protected $fillable = [
        'title',
        'slug',
        'featured',
        'sorting',
        'active',
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    public function portfolios()
    {
        return $this->hasMany(PORT06Portfolios::class, 'category_id', 'id');
    }
    public function getRelationCore()
    {
        return null;
    }
    public function scopeExists($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('port06_portfolios')->whereColumn('port06_portfolios.category_id', 'port06_portfolios_categories.id');
        });
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
