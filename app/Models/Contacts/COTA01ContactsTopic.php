<?php

namespace App\Models\Contacts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\Contacts\COTA01ContactsTopicFactory;

class COTA01ContactsTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COTA01ContactsTopicFactory::new();
    }

    protected $table = "cota01_contacts_topics";
    protected $fillable = [
        "contact_id",
        "title",
        "description",
        "path_image_icon",
        "sorting",
    ];

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
