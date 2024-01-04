<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI08TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI08Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI08TopicsFactory::new();
    }

    protected $table = "topi08_topics";
    protected $fillable = ['title', 'description', 'title_button', 'link_button', 'target_link_button', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
