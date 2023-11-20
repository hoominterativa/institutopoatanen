<?php

namespace App\Models\Contacts;

use Database\Factories\Contacts\COTA01ContactsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COTA01Contacts extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COTA01ContactsFactory::new();
    }

    protected $table = "cota01_contacts";
    protected $fillable = [
        "compliance_id",
        "title_page",
        "slug",
        "title_banner",
        "description_banner",
        "path_image_desktop_banner",
        "path_image_mobile_banner",
        "background_color",
        "title_section",
        "description_section",
        "title_form",
        "description_form",
        "title_button_form",
        "path_image_section_topic",
        "inputs_form",
        "email_form",
        "active",
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

    public function topicsForms()
    {
        return $this->hasMany(COTA01ContactsTopicForm::class, 'contact_id')->sorting();
    }

    public function topicsSection()
    {
        return $this->hasMany(COTA01ContactsTopic::class, 'contact_id')->sorting();
    }
}
