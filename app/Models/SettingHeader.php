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
        "dropdown",
        "select_dropdown",
        "condition",
        "exists",
        "limit",
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
}
