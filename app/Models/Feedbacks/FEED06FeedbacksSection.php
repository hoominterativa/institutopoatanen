<?php

namespace App\Models\Feedbacks;

use Database\Factories\Feedbacks\FEED06FeedbacksSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FEED06FeedbacksSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return FEED06FeedbacksSectionFactory::new();
    }

    protected $table = "feed06_feedbacks_sections";
    protected $fillable = ['title', 'title_button', 'link_button', 'target_link_button', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
