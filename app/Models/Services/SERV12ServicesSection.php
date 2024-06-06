<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV12ServicesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV12ServicesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV12ServicesSectionFactory::new();
    }

    protected $table = "serv12_services_sections";
    protected $fillable = ['title', 'description', 'subtitle', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
