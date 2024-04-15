<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV09ServicesStateFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV09ServicesState extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV09ServicesStateFactory::new();
    }

    protected $table = "serv09_services_states";
    protected $fillable = ['state', 'acronym', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function cities()
    {
        return $this->hasMany(SERV09ServicesCity::class, 'state_id')->active()->sorting()->pluck('city', 'id');
    }

}
