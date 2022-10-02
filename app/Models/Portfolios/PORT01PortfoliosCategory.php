<?php

namespace App\Models\Portfolios;

use Database\Factories\PORT01CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT01PortfoliosCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT01CategoryFactory::new();
    }

    protected $table = "port01_portfolios_categories";
    protected $fillable = ["title","slug","path_image_icon","view_menu","featured","active","sorting"];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
