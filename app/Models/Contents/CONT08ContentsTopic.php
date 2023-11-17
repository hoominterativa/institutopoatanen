<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT08ContentsTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT08ContentsTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT08ContentsTopicFactory::new();
    }

    protected $table = "cont08_contents_topics";
    protected $fillable = ['description', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
