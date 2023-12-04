<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT03PortfoliosFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT03Portfolios extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT03PortfoliosFactory::new();
    }

    protected $table = "port03_portfolios";
    protected $fillable = [];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
