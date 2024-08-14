<?php

namespace App\Models;

use Database\Factories\SettingSmtpFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingSmtp extends Model
{
    use HasFactory;

    protected $table = "setting_smtps";
    protected $fillable = [
        "email_test",
        "host",
        "port",
        "user",
        "password",
        "report",
        "encryption"
    ];
}
