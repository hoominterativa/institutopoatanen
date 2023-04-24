<?php

namespace App\Models\Units;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\Units\UNIT01UnitsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UNIT01Units extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT01UnitsFactory::new();
    }

    protected $table = "unit01_units";
    protected $fillable = ['title_unit', 'title', 'description', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function topic()
    {
        return $this->hasMany(UNIT01UnitsTopic::class, 'unit_id')->active()->sorting();
    }
}
