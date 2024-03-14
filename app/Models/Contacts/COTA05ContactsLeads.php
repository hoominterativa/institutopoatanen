<?php

namespace App\Models\Contacts;

use Database\Factories\Contacts\COTA05ContactsLeadsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COTA05ContactsLeads extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COTA05ContactsLeadsFactory::new();
    }

    protected $table = "cota05_contacts_leads";
    protected $fillable = ['contact_id', 'target_lead', 'json', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }
}
