<?php

namespace App\Models\Contacts;

use Database\Factories\Contacts\COTA05ContactsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COTA05Contacts extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COTA05ContactsFactory::new();
    }

    protected $table = "cota05_contacts";
    protected $fillable = [
        'slug', 'title_page', 'active',
        'title_banner', 'subtitle_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'background_color_banner', 'active_banner',
        'title_form', 'description_form', 'path_image_icon_form', 'active_form',
        'title_button_form', 'compliance_id', 'email_form', 'inputs_form',
        'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function forms()
    {
        return $this->hasMany(COTA05ContactsAssessment::class, 'contact_id')->active()->sorting();
    }
}
