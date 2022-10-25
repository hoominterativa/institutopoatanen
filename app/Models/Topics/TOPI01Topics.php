<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI01TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI01Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI01TopicsFactory::new();
    }

    protected $table = "topi01_topics";
    protected $fillable = [
        "title",
        "description",
        "link",
        "target_link",
        "active",
        "path_image_icon",
        "path_image",
        "sorting ",
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
