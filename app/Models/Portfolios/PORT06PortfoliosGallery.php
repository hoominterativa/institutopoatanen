<?php

namespace App\Models\Portfolios;

use Illuminate\Database\Eloquent\Model;

class PORT06PortfoliosGallery extends Model
{
    protected $table = "port06_portfolios_galleries";
    protected $fillable = [
        'portfolio_id',
        'path_image',
        'title',
        'sorting',
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    public function portfolio()
    {
        return $this->belongsTo(PORT06Portfolios::class, 'portfolio_id', 'id');
    }
}
