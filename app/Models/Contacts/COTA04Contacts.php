<?php

namespace App\Models\Contacts;

use Database\Factories\Contacts\COTA04ContactsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COTA04Contacts extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COTA04ContactsFactory::new();
    }

    protected $table = "cota04_contacts";
    protected $fillable = [];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
