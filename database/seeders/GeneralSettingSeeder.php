<?php

namespace Database\Seeders;

use Facade\Ignition\Support\FakeComposer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_settings')->insert([
            'phone' => '(71) 0000-0000',
            'whatsapp' => '(71) 0 0000-0000',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => '465',
            'smtp_user' => 'anderson@hoom.com.br',
            'smtp_password' => 'Nandos1306#',
            'path_logo_header_light' => 'uploads/tmp/logo-light.svg',
            'path_logo_header_dark' => 'uploads/tmp/logo-dark.svg',
            'path_logo_footer_light' => 'uploads/tmp/logo-light.svg',
            'path_logo_footer_dark' => 'uploads/tmp/logo-dark.svg',
            'path_favicon' => 'uploads/tmp/favicon.png',
            'path_logo_share' => 'uploads/tmp/logo.svg',
        ]);
    }
}
