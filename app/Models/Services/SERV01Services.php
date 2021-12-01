<?php

namespace App\Models\Services;

use Database\Factories\SERV01ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV01Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV01ServicesFactory::new();
    }

    protected $table = "";

    public function scopeSorting($query)
    {
        return $this->orderBy('sorting', 'ASC');
    }
}
