<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV09ServicesTopicsUpFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV09ServicesTopicsUp extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV09ServicesTopicsUpFactory::new();
    }

    protected $table = "serv09_services_topicsups";
    protected $fillable = ['service_id', 'title', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
