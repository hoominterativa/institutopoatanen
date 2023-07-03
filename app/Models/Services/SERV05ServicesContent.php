<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV05ServicesContentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV05ServicesContent extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV05ServicesContentFactory::new();
    }

    protected $table = "serv05_services_contents";
    protected $fillable = ['title', 'subtitle', 'text', 'section', 'service_id', 'path_image', 'path_image_icon', 'active', 'sorting', 'slug'];

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
