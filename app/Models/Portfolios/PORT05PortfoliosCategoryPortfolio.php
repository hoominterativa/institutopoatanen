<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT05PortfoliosCategoryPortfolioFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT05PortfoliosCategoryPortfolio extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT05PortfoliosCategoryPortfolioFactory::new();
    }

    protected $table = "port05_portfolios_categoryportfolios";
    protected $fillable = ['category_id', 'portfolio_id'];


}
