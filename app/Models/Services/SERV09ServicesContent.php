<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV09ServicesContentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV09ServicesContent extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV09ServicesContentFactory::new();
    }

    protected $table = "serv09_services_contents";
    protected $fillable = ['service_id', 'title', 'text', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
