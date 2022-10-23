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
        $InsertModelsMain = config('modelsConfig.InsertModelsMain');
        $modelsClass = config('modelsClass.Class');

        foreach ($InsertModelsMain as $module => $model) {
            foreach ($model as $code => $config) {

                $relationship = $modelsClass->$module->$code->relationship??false;
                if($relationship){
                    foreach ($relationship as $relation) {
                        $seedRelationQty = $relation['seedQty'];
                        $relation['class']::factory($seedRelationQty)->create();
                    }
                }

                $seedQty = $modelsClass->$module->$code->seedQty;
                $modelsClass->$module->$code->model::factory($seedQty)->create();

            }
        }

        User::factory(1)->create();
        $this->call([
            SettingThemeSeeder::class,
            OptimizationSeeder::class,
            GeneralSettingSeeder::class,
        ]);
    }
}
