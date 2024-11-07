<?php

namespace App\Models\Portfolios;

use Illuminate\Database\Eloquent\Model;

class PORT06PortfoliosCategory extends Model
{

    protected $table = "port06_portfolios_categories";
    protected $fillable = [
        'title',
        'slug',
        'featured',
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
    public function portfolios()
    {
        return $this->hasMany(PORT06Portfolios::class, 'category_id', 'id');
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
