<?php

namespace App\Models\Portfolios;

use Database\Factories\PORT01PortfoliosSubategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT01PortfoliosSubategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT01PortfoliosSubategoryFactory::new();
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
