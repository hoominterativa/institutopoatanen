<?php

namespace App\Models\Portfolios;

use Database\Factories\PORT01PortfoliosFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT01Portfolios extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT01PortfoliosFactory::new();
    }

    protected $table = "port01_portfolios";
    protected $fillable = ["title","slug","colors","description","text","path_image_box","path_image_left","path_image_right","title_testimonial","subtitle_testimonial","text_testimonial","path_image_testimonial","featured","active","sorting","category_id","subcategory_id"];

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
}
