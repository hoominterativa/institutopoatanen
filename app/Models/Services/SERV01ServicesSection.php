<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV01ServicesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV01ServicesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV01ServicesSectionFactory::new();
    }

    protected $table = "serv01_services_sections";
    protected $fillable = [
        "title_section",
        "subtitle_section",
        "description_section",
        "active_section",
        "title_banner",
        "description_banner",
        "path_image_banner",
    ];


    public function scopeActive($query)
    {
        return $query->where('active_section', 1);
    }

}
