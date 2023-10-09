<?php

namespace App\Models\Contacts;

use Database\Factories\Contacts\COTA04ContactsFormFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COTA04ContactsForm extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COTA04ContactsFormFactory::new();
    }

    protected $table = "cota04_contacts_forms";
    protected $fillable = ['inputs_form', 'category_id', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function categories(){
        return $this->belongsTo(COTA04ContactsCategory::class, 'category_id');
    }
}
