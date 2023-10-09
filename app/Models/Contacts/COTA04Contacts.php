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
    protected $fillable = [
        'slug', 'compliance_id', 'active', 'sorting',
        'title_banner','subtitle_banner', 'path_image_banner_desktop', 'path_image_banner_mobile', 'background_color_banner',
        'title_content', 'subtitle_content', 'description_content', 'path_image_content', 'title_button_form', 'email_form', 'title_compliance', 'subtitle_compliance',
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function sections(){
        return $this->hasMany(COTA04ContactsSection::class, 'contact_id');
    }
}
