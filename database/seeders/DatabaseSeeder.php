<?php

namespace Database\Seeders;

use App\Models\Contents\CONT01Contents;
use App\Models\Slides\SLID01Slides;
use App\Models\User;
use Illuminate\Database\Seeder;

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
        SLID01Slides::factory(1)->create();
        CONT01Contents::factory(1)->create();

        $this->call([
            SettingThemeSeeder::class,
            OptimizationSeeder::class,
            GeneralSettingSeeder::class,
            // ContactFormSeeder::class,
        ]);
    }
}
