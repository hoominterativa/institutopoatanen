<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT01UnitsTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT01UnitsTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT01UnitsTopicFactory::new();
    }

    protected $table = "unit01_units_topics";
    protected $fillable = ['unit_id','title', 'subtitle', 'description', 'link', 'target_link', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
