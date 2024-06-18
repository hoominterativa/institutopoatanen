<?php

namespace App\Models\Portfolios;

use Database\Factories\PORT05PortfoliosTestimonialFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT05PortfoliosTestimonial extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT05PortfoliosTestimonialFactory::new();
    }

    protected $table = "";
    protected $fillable = [];

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
