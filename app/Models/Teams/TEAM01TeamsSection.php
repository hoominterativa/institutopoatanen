<?php

namespace App\Models\Teams;

use Database\Factories\Teams\TEAM01TeamsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TEAM01TeamsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TEAM01TeamsSectionFactory::new();
    }

    protected $table = "team01_teams_sections";
    protected $fillable = ['title', 'description', 'subtitle', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
