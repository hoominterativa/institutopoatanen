<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT04PortfoliosAdditionalTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT04PortfoliosAdditionalTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT04PortfoliosAdditionalTopicFactory::new();
    }

    protected $table = "port04_portfolios_additionaltopics";
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
