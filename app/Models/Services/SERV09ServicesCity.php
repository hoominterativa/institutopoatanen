<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV09ServicesCityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV09ServicesCity extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV09ServicesCityFactory::new();
    }

    protected $table = "serv09_services_cities";
    protected $fillable = ['state_id', 'city', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function state()
    {
        return $this->belongsTo(SERV09ServicesState::class, 'state_id');
    }

}
