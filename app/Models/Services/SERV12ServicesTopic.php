<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV12ServicesTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV12ServicesTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV12ServicesTopicFactory::new();
    }

    protected $table = "serv12_services_topics";
    protected $fillable = ['service_id', 'title', 'description', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function galleries()
    {
        return $this->hasMany(SERV12ServicesTopicGallery::class, 'topic_id')->sorting();
    }
}
