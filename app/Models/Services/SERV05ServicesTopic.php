<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV05ServicesTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV05ServicesTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV05ServicesTopicFactory::new();
    }

    protected $table = "serv05_services_topics";
    protected $fillable = ['title', 'description', 'subtitle', 'service_id', 'path_image', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function service()
    {
        return $this->belongsTo(SERV05Services::class, 'service_id');
    }
}
