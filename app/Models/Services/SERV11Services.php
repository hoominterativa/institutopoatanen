<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV11ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV11Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV11ServicesFactory::new();
    }

    protected $table = "serv11_services";
    protected $fillable = ['session_id', 'slug', 'title', 'subtitle', 'description', 'text', 'path_image_icon', 'path_image_box', 'path_image', 'active', 'featured', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function session()
    {
        return $this->belongsTo(SERV11ServicesSession::class, 'session_id');
    }
}
