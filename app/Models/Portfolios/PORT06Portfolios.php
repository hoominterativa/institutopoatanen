<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT06PortfoliosFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT06Portfolios extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT06PortfoliosFactory::new();
    }

    protected $table = "port06_portfolios";
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
