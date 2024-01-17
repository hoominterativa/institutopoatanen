<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV10ServicesTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV10ServicesTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV10ServicesTopicFactory::new();
    }

    protected $table = "serv10_services_topics";
    protected $fillable = ['service_id', 'title', 'description', 'path_image', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
