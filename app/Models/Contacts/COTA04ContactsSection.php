<?php

namespace App\Models\Contacts;

use Database\Factories\Contacts\COTA04ContactsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COTA04ContactsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COTA04ContactsSectionFactory::new();
    }

    protected $table = "cota04_contacts_sections";
    protected $fillable = ['contact_id', 'title', 'description', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function contacts(){
        return $this->belongsTo(COTA04Contacts::class, 'contact_id');
    }

    public function categories(){
        return $this->hasMany(COTA04ContactsCategory::class, 'section_id');
    }

    public function forms(){
        return $this->hasMany(COTA04ContactsForm::class, 'section_id');
    }
}
