<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI11TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI11Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI11TopicsFactory::new();
    }

    protected $table = "topi11_topics";
    protected $fillable = [
        'title',
        'text',
        'active',
        'sorting',
        'path_image_icon'
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
