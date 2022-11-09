<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU01AboutsTopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU01AboutsTopics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU01AboutsTopicsFactory::new();
    }

    protected $table = "abou01_abouts_topics";
    protected $fillable = [
        "title",
        "description",
        "path_image_icon",
        "sorting",
        "about_id",
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
