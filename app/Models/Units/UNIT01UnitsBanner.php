<?php

namespace App\Models\Units;

use Database\Factories\UNIT01UnitsBannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT01UnitsBanner extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT01UnitsBannerFactory::new();
    }

    protected $table = "unit01_units_banners";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
