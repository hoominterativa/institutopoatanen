<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Optimization;
use App\Models\SettingTheme;
use App\Models\GeneralSetting;
use Illuminate\Database\Seeder;
use App\Models\Slides\SLID01Slides;
use App\Models\Contents\CONT01Contents;
use App\Models\Portfolios\PORT01Portfolios;
use App\Models\Portfolios\PORT01PortfoliosSection;
use App\Models\Portfolios\PORT01PortfoliosCategory;
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
                $relationshipSon = $modelsClass->$module->$code->relationshipSon??false;

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

        if(!User::get()->count()) User::factory(1)->create();

        if(!SettingTheme::first()){
            $this->call([
                SettingThemeSeeder::class,
            ]);
        }

        if(!Optimization::first()){
            $this->call([
                OptimizationSeeder::class,
            ]);
        }

        if(!GeneralSetting::first()){
            $this->call([
                GeneralSettingSeeder::class,
            ]);
        }
    }
}
