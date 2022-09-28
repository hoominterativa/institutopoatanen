<?php

namespace App\Models\Portfolios;

use Database\Factories\PORT01PortfoliosGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT01PortfoliosGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT01PortfoliosGalleryFactory::new();
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
