<?php

namespace App\Models\Schedules;

use Database\Factories\Schedules\SCHE02SchedulesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SCHE02Schedules extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SCHE02SchedulesFactory::new();
    }

    protected $table = "sche02_schedules";
    protected $fillable = [
        'event_locale', 'event_date', 'event_title', 'informations', 'title_button_one', 'link_button_one', 'target_link_button_one',
        'title_button_two', 'link_button_two', 'active', 'featured', 'sorting'
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
}
