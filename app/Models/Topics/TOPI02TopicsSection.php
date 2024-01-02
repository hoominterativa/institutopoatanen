<?php

namespace App\Models\Topics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\Topics\TOPI02TopicsSectionFactory;

class TOPI02TopicsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI02TopicsSectionFactory::new();
    }

    protected $table = "topi02_topics_sections";
    protected $fillable = ['title','subtitle','description','active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
