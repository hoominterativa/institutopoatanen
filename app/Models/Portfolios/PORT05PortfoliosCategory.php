<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT05PortfoliosCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT05PortfoliosCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT05PortfoliosCategoryFactory::new();
    }

    protected $table = "port05_portfolios_categories";
    protected $fillable = ['slug', 'title', 'featured', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function portfolios()
    {
        return $this->belongsToMany(PORT05Portfolios::class);
    }
}
