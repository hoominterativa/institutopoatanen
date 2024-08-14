<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT05PortfoliosTestimonialFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT05PortfoliosTestimonial extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT05PortfoliosTestimonialFactory::new();
    }

    protected $table = "port05_portfolios_testimonials";
    protected $fillable = [
        'portfolio_id',
        'name',
        'profession',
        'feedback',
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

    public function portfolio()
    {
        return $this->belongsTo(PORT05Portfolios::class, 'portfolio_id');
    }
}
