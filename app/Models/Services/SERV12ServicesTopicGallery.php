<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV12ServicesTopicGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV12ServicesTopicGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV12ServicesTopicGalleryFactory::new();
    }

    protected $table = "serv12_services_topicgalleries";
    protected $fillable = [
        'topic_id',
        'path_image',
        'link_video',
        'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function topic()
    {
        return $this->belongsTo(SERV12ServicesTopic::class, 'topic_id');
    }
}
