<?php

namespace App\Models\Topics;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\Topics\TOPI02TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TOPI02Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI02TopicsFactory::new();
    }

    protected $table = "topi02_topics";
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
