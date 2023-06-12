<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT03UnitsBannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT03UnitsBanner extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT03UnitsBannerFactory::new();
    }

    protected $table = "unit03_units_banners";
    protected $fillable = ['title', 'subtitle', 'background_color', 'path_image_desktop', 'path_image_mobile', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
