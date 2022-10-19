<?php

namespace App\Models\Portfolios;

use Database\Factories\Portfolios\PORT01PortfoliosFactory;
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
        return $query->where('active', 1)->where('featured', 1);
    }

    public function getRelationCore()
    {
        return null;
    }

    public function galleries()
    {
        return $this->hasMany(PORT01PortfoliosGallery::class, 'portfolio_id');
    }

    public function category()
    {
        return $this->belongsTo(PORT01PortfoliosCategory::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(PORT01PortfoliosSubategory::class, 'subcategory_id');
    }
}
