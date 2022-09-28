<?php

namespace App\Models\Portfolios;

use Database\Factories\PORT01PortfoliosSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT01PortfoliosSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT01PortfoliosSectionFactory::new();
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
