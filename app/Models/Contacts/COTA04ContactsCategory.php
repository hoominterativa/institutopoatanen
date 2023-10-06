<?php

namespace App\Models\Contacts;

use Database\Factories\Contacts\COTA04ContactsCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COTA04ContactsCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COTA04ContactsCategoryFactory::new();
    }

    protected $table = "cota04_contacts_categories";
    protected $fillable = ['slug', 'title', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeExists($query){
        return $query->whereExists(function($query){
            $query->select('id')->from('cota04_contacts')->whereColumn('cota04_contacts.category_id', 'cota04_contacts_categories.id');
        });
    }
}
