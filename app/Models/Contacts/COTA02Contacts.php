<?php

namespace App\Models\Contacts;

use Database\Factories\Contacts\COTA02ContactsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COTA02Contacts extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COTA02ContactsFactory::new();
    }

    protected $table = "cota02_contacts";
    protected $fillable = [
        'title_banner', 'subtitle_banner', 'path_image_banner_desktop', 'path_image_banner_mobile', 'background_color_banner',
        'path_image_topic_desktop', 'path_image_topic_mobile', 'background_color_topic',
        'title_form', 'description_form', 'path_image_form_desktop', 'path_image_form_mobile', 'background_color_form',
        "email_form", "slug", "inputs_form", 'title_button_form', "compliance_id", 'active', 'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function topics()
    {
        return $this->hasMany(COTA02ContactsTopic::class, 'contact_id')->sorting();
    }
}
