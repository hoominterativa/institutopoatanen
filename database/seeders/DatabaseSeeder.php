<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Slides\SLID01Slides;
use App\Models\Contents\CONT01Contents;
use App\Models\Portfolios\PORT01Portfolios;
use App\Models\Portfolios\PORT01PortfoliosCategory;
use App\Models\Portfolios\PORT01PortfoliosSection;
use App\Models\Portfolios\PORT01PortfoliosSubategory;

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
        PORT01PortfoliosSection::factory(1)->create();
        PORT01PortfoliosCategory::factory(4)->create();
        PORT01PortfoliosSubategory::factory(4)->create();
        PORT01Portfolios::factory(10)->create();

        $this->call([
            SettingThemeSeeder::class,
            OptimizationSeeder::class,
            GeneralSettingSeeder::class,
            // ContactFormSeeder::class,
        ]);
    }
}
