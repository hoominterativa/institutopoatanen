<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI04TopicsGalleryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI04TopicsGallery extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI04TopicsGalleryFactory::new();
    }

    protected $table = "topi04_topics_galleries";
    protected $fillable = ['topic_id', 'path_image', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

}
