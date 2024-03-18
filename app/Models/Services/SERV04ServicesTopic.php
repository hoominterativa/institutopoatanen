<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV04ServicesTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV04ServicesTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV04ServicesTopicFactory::new();
    }

    protected $table = "serv04_services_topics";
    protected $fillable = [
        'service_id', 'title', 'text', 'active', 'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    
}
