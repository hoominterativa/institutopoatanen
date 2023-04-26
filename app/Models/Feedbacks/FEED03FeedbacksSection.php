<?php

namespace App\Models\Feedbacks;

use Database\Factories\Feedbacks\FEED03FeedbacksSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FEED03FeedbacksSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return FEED03FeedbacksSectionFactory::new();
    }

    protected $table = "feed03_feedbacks_sections";
    protected $fillable = ['title', 'subtitle', 'path_image_icon', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
