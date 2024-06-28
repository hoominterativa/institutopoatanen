<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV12ServicesVideoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV12ServicesVideo extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV12ServicesVideoFactory::new();
    }

    protected $table = "serv12_services_videos";
    protected $fillable = ['service_id', 'link', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
