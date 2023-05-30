<?php

namespace App\Models\Teams;

use Database\Factories\Teams\TEAM01TeamsSectionTeamFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TEAM01TeamsSectionTeam extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TEAM01TeamsSectionTeamFactory::new();
    }

    protected $table = "team01_teams_sectionteams";
    protected $fillable = ['title', 'subtitle', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
