<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU04AboutsTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU04AboutsTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU04AboutsTopicFactory::new();
    }

    protected $table = "abou04_abouts_topics";
    protected $fillable = ['about_id', 'title', 'description', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
