<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV11ServicesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV11ServicesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV11ServicesSectionFactory::new();
    }

    protected $table = "serv11_services_sections";
    protected $fillable = ['title_section', 'subtitle_section', 'description_section', 'active_section', 'title_banner', 'subtitle_banner', 'description_banner', 'active_banner', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActiveSection($query)
    {
        return $query->where('active_section', 1);
    }

    public function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }
}
