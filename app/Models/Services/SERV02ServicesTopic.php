<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV02ServicesTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV02ServicesTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV02ServicesTopicFactory::new();
    }

    protected $table = "serv02_services_topics";
    protected $fillable = ['service_id','title', 'description', 'path_image', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
