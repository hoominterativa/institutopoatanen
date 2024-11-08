<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT06PortfoliosFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT06Portfolios extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT06PortfoliosFactory::new();
    }

    protected $table = "port06_portfolios";
    protected $fillable = [
        'category_id',
        'title',
        'subtitle',
        'paragraph',
        'text',
        'path_image_box',
        'path_image',
        'active',
        'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    public function getRelationCore()
    {
        return null;
    }
    public function galleries()
    {
        return $this->hasMany(PORT06PortfoliosGallery::class, 'portfolio_id');
    }
}
