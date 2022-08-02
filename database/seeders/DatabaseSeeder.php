<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Topics\TOPI01Topics;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create();

        $this->call([
            SettingThemeSeeder::class,
            OptimizationSeeder::class,
            GeneralSettingSeeder::class,
            // ContactFormSeeder::class,
        ]);
    }
}
