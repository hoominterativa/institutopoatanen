<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT12ContentsTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT12ContentsTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT12ContentsTopicFactory::new();
    }

    protected $table = "cont12_contents_topics";
    protected $fillable = ['content_id', 'title', 'path_image_icon', 'title_button', 'link_button', 'target_link_button', 'path_archive', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
