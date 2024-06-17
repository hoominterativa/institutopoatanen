<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI13TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI13Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI13TopicsFactory::new();
    }

    protected $table = "topi13_topics";
    protected $fillable = [
        'text',
        'title_button',
        'link_button',
        'target_link',
        'path_image_icon',
        'path_image_desktop',
        'path_image_mobile',
        'color',
        'active',
        'sorting'
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
