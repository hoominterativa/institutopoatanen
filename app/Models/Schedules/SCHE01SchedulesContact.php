<?php

namespace App\Models\Schedules;

use Database\Factories\Schedules\SCHE01SchedulesContactFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SCHE01SchedulesContact extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SCHE01SchedulesContactFactory::new();
    }

    protected $table = "sche01_schedules_contacts";
    protected $fillable = ['compliance_id', 'unit_id', 'title', 'subtitle', 'description', 'title_button', 'inputs_form', 'email_form', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
