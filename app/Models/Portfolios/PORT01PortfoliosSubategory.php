<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT01SubategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT01PortfoliosSubategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT01SubategoryFactory::new();
    }

    protected $table = "port01_portfolios_subategories";
    protected $fillable = ["title","slug","description","featured","active","sorting"];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1)->where('featured', 1);
    }

    public function scopeExists($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('port01_portfolios')->whereColumn('port01_portfolios.category_id = port01_portfolios_subategories.id');
        });
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
