<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT04PortfoliosTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT04PortfoliosTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT04PortfoliosTopicFactory::new();
    }

    protected $table = "port04_portfolios_topics";
    protected $fillable = ['portfolio_id', 'title', 'text', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
