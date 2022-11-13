<?php

namespace App\Models\Abouts;


use Illuminate\Database\Eloquent\Model;
use Database\Factories\Abouts\ABOU01AboutsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ABOU01Abouts extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU01AboutsFactory::new();
    }

    protected $table = "abou01_abouts";
    protected $fillable = [
        "title_section",
        "subtitle_section",
        "description_section",
        "title_banner",
        "subtitle_banner",
        "path_image_banner",
        "title",
        "subtitle",
        "text",
        "title_inner_section",
        "subtitle_inner_section",
        "path_image_inner_section",
        "text_inner_section",
        "sorting",
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function topics()
    {
        return $this->hasMany(ABOU01AboutsTopics::class, 'about_id')->sorting();
    }
}
