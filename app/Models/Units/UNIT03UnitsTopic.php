<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT03UnitsTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT03UnitsTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT03UnitsTopicFactory::new();
    }

    protected $table = "unit03_units_topics";
    protected $fillable = ['title', 'description', 'path_image_icon', 'unit_id', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function unit()
    {
        return $this->belongsTo(UNIT01Units::class, 'unit_id');
    }
}
