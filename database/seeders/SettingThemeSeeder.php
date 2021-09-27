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
            'color_scheme_mode' => 'light',
            'leftsidebar_color' => 'light',
            'leftsidebar_size' => 'default',
            'topbar_color' => 'light',
            'created_at' => now()
        ]);
    }
}
