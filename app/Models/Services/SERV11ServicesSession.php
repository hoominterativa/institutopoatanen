<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV11ServicesSessionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV11ServicesSession extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV11ServicesSessionFactory::new();
    }

    protected $table = "serv11_services_sessions";
    protected $fillable = ['slug', 'title', 'subtitle', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function services()
    {
        return $this->hasMany(SERV11Services::class, 'session_id')->active()->sorting();
    }

    public function scopeExists($query){
        return $query->whereExists(function($query){
            $query->select('id')->from('serv11_services')->whereColumn('serv11_services.session_id', 'serv11_services_sessions.id');
        });
    }

    // DROPDOW MENU

    public function scopeExistsRegister($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('serv11_services')->whereColumn('serv11_services.session_id', 'serv11_services_sessions.id');
        });
    }

}
