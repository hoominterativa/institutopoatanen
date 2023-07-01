<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV05ServicesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV05ServicesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV05ServicesSectionFactory::new();
    }

    protected $table = "serv05_services_sections";
    protected $fillable =
    [
        //Home
        'title', 'description', 'subtitle',
        //Banner
        'title_banner', 'subtitle_banner',
        //Topic
        'title_topic', 'subtitle_topic', 'description_topic',
        'active'
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
