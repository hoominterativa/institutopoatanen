<?php

namespace App\Models\Contacts;

use Database\Factories\COTA01ContactsTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COTA01ContactsTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COTA01ContactsTopicFactory::new();
    }

    protected $table = "";
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
