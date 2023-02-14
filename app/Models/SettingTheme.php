<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingTheme extends Model
{
    use HasFactory;

    protected $table = 'setting_themes';
    protected $fillable = [
        'user_id',
        'color_scheme_mode',
        'leftsidebar_color',
        'leftsidebar_size',
        'topbar_color',
    ];
}
