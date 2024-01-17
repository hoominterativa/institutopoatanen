<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV10ServicesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV10ServicesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV10ServicesSectionFactory::new();
    }

    protected $table = "serv10_services_sections";
    protected $fillable = [
        //Section home
        'title_section', 'subtitle_section', 'description_section', 'active_section',
        //Banner page
        'title_banner', 'description_banner', 'active_banner',
    ];

    public function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }

    public function scopeActiveSection($query)
    {
        return $query->where('active_section', 1);
    }

}
