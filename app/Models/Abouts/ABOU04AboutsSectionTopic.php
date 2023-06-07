<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU04AboutsSectionTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU04AboutsSectionTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU04AboutsSectionTopicFactory::new();
    }

    protected $table = "abou04_abouts_sectiontopics";
    protected $fillable = ['path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
