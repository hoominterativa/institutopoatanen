<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT03UnitsBannerShowFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT03UnitsBannerShow extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT03UnitsBannerShowFactory::new();
    }

    protected $table = "unit03_units_bannershows";
    protected $fillable = ['unit_id', 'title', 'subtitle', 'background_color', 'path_image_desktop', 'path_image_mobile', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function unit()
    {
        return $this->belongsTo(UNIT03Units::class, 'unit_id');
    }
}
