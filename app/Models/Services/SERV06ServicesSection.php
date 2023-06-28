<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV06ServicesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV06ServicesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV06ServicesSectionFactory::new();
    }

    protected $table = "serv06_services_sections";
    protected $fillable = ['title', 'subtitle', 'description', 'path_image', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active',];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
