<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV02ServicesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV02ServicesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV02ServicesSectionFactory::new();
    }

    protected $table = "serv02_services_sections";
    protected $fillable = [
        'title_section', 'subtitle_section', 'description_section', 'active_section', 'title_banner', 'description_banner', 'active_banner'
    ];

    public function scopeActiveSection($query)
    {
        return $query->where('active_section', 1);
    }

    public function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }
}
