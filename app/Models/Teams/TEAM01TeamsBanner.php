<?php

namespace App\Models\Teams;

use Database\Factories\Teams\TEAM01TeamsBannerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TEAM01TeamsBanner extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TEAM01TeamsBannerFactory::new();
    }

    protected $table = "team01_teams_banners";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
