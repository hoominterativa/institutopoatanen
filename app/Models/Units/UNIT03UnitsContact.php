<?php

namespace App\Models\Units;

use Database\Factories\Units\UNIT03UnitsContactFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNIT03UnitsContact extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return UNIT03UnitsContactFactory::new();
    }

    protected $table = "unit03_units_contacts";
    protected $fillable = ['unit_id', 'title', 'subtitle', 'title_button', 'inputs_form', 'email_form', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

   public function unit()
   {
    return $this->belongsTo(UNIT03Units::class, 'unit_id');
   }
}
