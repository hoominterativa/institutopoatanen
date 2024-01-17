<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV10ServicesContentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV10ServicesContent extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV10ServicesContentFactory::new();
    }

    protected $table = "serv10_services_contents";
    protected $fillable = ['service_id', 'title', 'description', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
