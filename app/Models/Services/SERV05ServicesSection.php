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
    protected $fillable = ['title', 'description', 'subtitle', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
