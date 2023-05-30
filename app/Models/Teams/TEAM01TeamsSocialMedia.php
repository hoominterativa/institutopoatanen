<?php

namespace App\Models\Teams;

use Database\Factories\Teams\TEAM01TeamsSocialMediaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TEAM01TeamsSocialMedia extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TEAM01TeamsSocialMediaFactory::new();
    }

    protected $table = "team01_teams_socialmedia";
    protected $fillable = ['link', 'target_link', 'team_id', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function team()
    {
        return $this->belongsTo(TEAM01Teams::class, 'team_id');
    }
}
