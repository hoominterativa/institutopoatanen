<?php

namespace App\Models\Portfolios;

use Database\Factories\PORT01PortfoliosCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT01PortfoliosCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT01PortfoliosCategoryFactory::new();
    }

    protected $table = "";

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
