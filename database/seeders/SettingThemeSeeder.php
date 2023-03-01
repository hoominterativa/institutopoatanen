<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting_themes')->insert([
            'user_id' => User::first()->id,
            'color_scheme_mode' => 'dark',
            'leftsidebar_color' => 'dark',
            'leftsidebar_size' => 'default',
            'topbar_color' => 'dark',
            'created_at' => now()
        ]);
    }
}
