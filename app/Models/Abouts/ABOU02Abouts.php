<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU02AboutsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU02Abouts extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU02AboutsFactory::new();
    }

    protected $table = "abou02_abouts";
    protected $fillable = ['title', 'subtitle', 'text'];

    public function topics()
    {
        return $this->hasMany(ABOU02AboutsTopic::class, 'about_id')->sorting();
    }

}
