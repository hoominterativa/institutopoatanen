<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $table = 'general_settings';
    protected $fillable = [
        "path_logo_header_light",
        "path_logo_header_dark",
        "path_logo_footer_light",
        "path_logo_footer_dark",
        "path_logo_share",
        "path_favicon",
        "phone",
        "whatsapp",
        "address",
        "btn_cta_header",
        "btn_cta_footer",
    ];
}
