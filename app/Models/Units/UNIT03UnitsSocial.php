<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT03UnitsSocialFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT03UnitsSocial extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT03UnitsSocialFactory::new();
    }

    protected $table = "unit03_units_socials";
    protected $fillable = ['unit_id', 'link', 'target_link', 'path_image_icon', 'active', 'sorting'];

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
        return $this->belongsTo(UNIT03Units::class, 'unit_id');
    }


}
