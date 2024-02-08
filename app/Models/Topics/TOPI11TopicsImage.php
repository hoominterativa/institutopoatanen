<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI11TopicsImageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI11TopicsImage extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI11TopicsImageFactory::new();
    }

    protected $table = "topi11_topics_images";
    protected $fillable = ['path_image', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
