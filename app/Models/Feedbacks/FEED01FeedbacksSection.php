<?php

namespace App\Models\Feedbacks;

use Database\Factories\Feedbacks\FEED01FeedbacksSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FEED01FeedbacksSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return FEED01FeedbacksSectionFactory::new();
    }

    protected $table = "feed01_feedbacks_sections";
    protected $fillable = [
        'title', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
