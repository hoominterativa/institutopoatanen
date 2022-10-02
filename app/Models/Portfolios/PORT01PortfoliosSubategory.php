<?php

namespace App\Models\Portfolios;

use Database\Factories\PORT01SubategoryFactory;
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
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
