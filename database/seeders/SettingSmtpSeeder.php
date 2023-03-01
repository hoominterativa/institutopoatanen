<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SettingSmtpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting_smtps')->insert([
            'email_test' => 'anderson@hoom.com.br',
            'host' => 'smtp.gmail.com',
            'port' => '465',
            'user' => 'anderson@hoom.com.br',
            'password' => 'mgcizsuyacusvgcd',
        ]);
    }
}
