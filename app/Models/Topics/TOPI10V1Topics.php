<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI10V1TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI10V1Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI10V1TopicsFactory::new();
    }

    protected $table = "topi10v1_topics";
    protected $fillable = ['title', 'description', 'path_image_icon', 'path_image_box', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
