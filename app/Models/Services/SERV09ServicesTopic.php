<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV09ServicesTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV09ServicesTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV09ServicesTopicFactory::new();
    }

    protected $table = "serv09_services_topics";
    protected $fillable = ['service_id', 'title', 'path_image', 'active', 'featured', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function service()
    {
        return $this->belongsTo(SERV09Services::class, 'service_id');
    }
}
