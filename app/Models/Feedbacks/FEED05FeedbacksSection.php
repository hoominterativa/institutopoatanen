<?php

namespace App\Models\Feedbacks;

use Database\Factories\Feedbacks\FEED05FeedbacksSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FEED05FeedbacksSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return FEED05FeedbacksSectionFactory::new();
    }

    protected $table = "feed05_feedbacks_sections";
    protected $fillable = ['title', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
