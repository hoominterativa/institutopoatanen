<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT09ContentsTopicSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT09ContentsTopicSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT09ContentsTopicSectionFactory::new();
    }

    protected $table = "cont09_contents_topicsections";
    protected $fillable = ['title', 'subtitle', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
