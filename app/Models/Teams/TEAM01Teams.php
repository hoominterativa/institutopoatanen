<?php

namespace App\Models\Teams;

use Database\Factories\Teams\TEAM01TeamsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TEAM01Teams extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TEAM01TeamsFactory::new();
    }

    protected $table = "team01_teams";
    protected $fillable = [
        'category_id', 'title', 'description', 'slug', 'subtitle', 'text', 'title_button', 'link_button', 'target_link_button',
        'path_image_icon', 'path_image_box', 'featured', 'active', 'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function category()
    {
        return $this->belongsTo(TEAM01TeamsCategory::class, 'category_id');
    }

    public function social()
    {
        return $this->hasMany(TEAM01TeamsSocialMedia::class, 'team_id');
    }
}
