<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV07ServicesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV07ServicesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV07ServicesSectionFactory::new();
    }

    protected $table = "serv07_services_sections";
    protected $fillable = ['title', 'description', 'subtitle', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
