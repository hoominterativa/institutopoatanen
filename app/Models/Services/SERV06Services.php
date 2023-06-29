<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV06ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV06Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV06ServicesFactory::new();
    }

    protected $table = "serv06_services";
    protected $fillable = ['title_section','title', 'slug', 'subtitle', 'text', 'path_image', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
