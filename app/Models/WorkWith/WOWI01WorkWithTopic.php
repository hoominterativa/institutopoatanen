<?php

namespace App\Models\WorkWith;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\WorkWith\WOWI01WorkWithTopicFactory;

class WOWI01WorkWithTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return WOWI01WorkWithTopicFactory::new();
    }

    protected $table = "wowi01_workwith_topics";
    protected $fillable = [
        "title",
        "description",
        "path_image_icon",
        "path_image_thumbnail",
        "active",
        "sorting",
        "link",
        "link_target",
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
