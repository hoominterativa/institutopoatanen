<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT02PortfoliosSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT02PortfoliosSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT02PortfoliosSectionFactory::new();
    }

    protected $table = "port02_portfolios_sections";
    protected $fillable = ['title', 'description', 'path_image_icon', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
