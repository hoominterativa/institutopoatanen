<?php

namespace App\Models\Teams;

use Database\Factories\Teams\TEAM01TeamsCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TEAM01TeamsCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TEAM01TeamsCategoryFactory::new();
    }

    protected $table = "team01_teams_categories";
    protected $fillable = ['title', 'slug', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeExists($query)
    {
        return $query->whereExists(function ($query){
            $query->select('id')->from('team01_teams')->whereRaw('team01_teams.category_id', 'team01_teams_categories.id');
        });
    }
}
