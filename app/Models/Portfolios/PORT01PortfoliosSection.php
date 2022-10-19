<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT01SectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT01PortfoliosSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT01SectionFactory::new();
    }

    protected $table = "port01_portfolios_sections";
    protected $fillable = ["title","description","active","path_image"];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
