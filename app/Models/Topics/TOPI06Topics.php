<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI06TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI06Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI06TopicsFactory::new();
    }

    protected $table = "topi06_topics";
    protected $fillable = [
        'title', 'description', 'path_image_icon', 'path_image',
        'title_button', 'link_button', 'target_link_button', 'active', 'sorting',
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
