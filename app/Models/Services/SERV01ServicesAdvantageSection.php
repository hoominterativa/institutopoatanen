<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\Services\SERV01ServicesAdvantageSectionFactory;

class SERV01ServicesAdvantageSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV01ServicesAdvantageSectionFactory::new();
    }

    protected $table = "serv01_services_advantagesections";
    protected $fillable = [
        "title",
        "subtitle",
        "description",
        "active",
        "service_id",
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
