<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT06PortfoliosSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT06PortfoliosSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT06PortfoliosSectionFactory::new();
    }
    
    protected $table = "port06_portfolios_sections";
    protected $fillable = [
        'title',
        'slug',
        'paragraph',
        'title_button',
        'link_button',
        'target_link_button',
        'sorting',
        'active',
    ];

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
