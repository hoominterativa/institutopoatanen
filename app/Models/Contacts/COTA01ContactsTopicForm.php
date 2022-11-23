<?php

namespace App\Models\Contacts;

use Database\Factories\COTA01ContactsTopicFormFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COTA01ContactsTopicForm extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COTA01ContactsTopicFormFactory::new();
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
