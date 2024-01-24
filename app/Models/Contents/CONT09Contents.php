<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT09ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT09Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT09ContentsFactory::new();
    }

    protected $table = "cont09_contents";
    protected $fillable = [
        'title', 'subtitle', 'link', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active', 'sorting',
        //Section
        'title_section', 'subtitle_section', 'active_section'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeActiveSection($query)
    {
        return $query->where('active_section', 1);
    }

    public function topics()
    {
        return $this->hasMany(CONT09ContentsTopic::class, 'content_id')->active()->sorting();
    }
}
