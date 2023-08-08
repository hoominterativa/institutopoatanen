<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV07ServicesVideoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV07ServicesVideo extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV07ServicesVideoFactory::new();
    }

    protected $table = "serv07_services_videos";
    protected $fillable = ['category_id', 'link', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function category()
    {
        return $this->belongsTo(SERV07ServicesCategory::class, 'category_id');
    }
}
