<?php

namespace App\Models\Contacts;

use Database\Factories\Contacts\COTA02ContactsTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COTA02ContactsTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COTA02ContactsTopicFactory::new();
    }

    protected $table = "cota02_contacts_topics";
    protected $fillable = [
        'contact_id', 'title', 'description', 'path_image_icon', 'active', 'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
