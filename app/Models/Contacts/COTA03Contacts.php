<?php

namespace App\Models\Contacts;

use Database\Factories\Contacts\COTA03ContactsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COTA03Contacts extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COTA03ContactsFactory::new();
    }

    protected $table = "cota03_contacts";
    protected $fillable = [
        'title_banner', 'subtitle_banner', 'path_image_banner_desktop', 'path_image_banner_mobile', 'background_color_banner',
        'title_content', 'subtitle_content','path_image_content', 'description_content', 'title_button_content', 'link_button_content', 'target_link_button_content',
        'title_form', 'description_form', 'email_form', 'slug', 'inputs_form', 'title_button_form', 'compliance_id', 'active', 'sorting'
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
