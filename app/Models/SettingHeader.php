<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingHeader extends Model
{
    use HasFactory;

    protected $table = "setting_headers";
    protected $fillable = [
        "title",
        "module",
        "model",
        "page",
        "link",
        "target_link",
        "dropdown",
        "select_dropdown",
        "exists",
        "limit",
        "sorting",
        "active",
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
