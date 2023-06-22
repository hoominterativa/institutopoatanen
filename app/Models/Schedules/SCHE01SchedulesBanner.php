<?php

namespace App\Models\Schedules;

use Database\Factories\Schedules\SCHE01SchedulesBannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SCHE01SchedulesBanner extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SCHE01SchedulesBannerFactory::new();
    }

    protected $table = "sche01_schedules_banners";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
