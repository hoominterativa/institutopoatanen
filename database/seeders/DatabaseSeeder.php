<?php

namespace Database\Seeders;

use App\Models\CallToActionTitle;
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
use App\Models\SettingSmtp;
use Exception;

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

        foreach ($InsertModelsMain as $module => $model) {
            foreach ($model as $code => $config) {
                $modelsClass = config('modelsClass.Class');
                $moduleName = explode('.', $module)[0];

                $relationship = $modelsClass->$moduleName->$code->relationship??false;
                $relationshipSon = $modelsClass->$moduleName->$code->relationshipSon??false;
                if($relationship){
                    foreach ($relationship as $relation) {
                        $seedRelationQty = $relation["seedQty"];
                        $relation["class"]::factory($seedRelationQty)->create();
                    }
                }

                $seedQty = $modelsClass->$moduleName->$code->seedQty;
                $modelsClass->$moduleName->$code->model::factory($seedQty)->create();

                if(file_exists('app/Models/'.$module.'/'.$code.$module.'Section.php')){
                    if($config->ViewHome){
                        $namespaceFactorySection = 'App\Models\\'.$module.'\\'.$code.$module.'Section';
                        $namespaceFactorySection::factory(1)->create();
                    }
                }

            }
        }

        $ModelsCompliances = config('modelsConfig.ModelsCompliances');
        $class = config('modelsClass.Class');

        if(isset($ModelsCompliances->Code)){
            if($ModelsCompliances->Code <> ''){
                $code = $ModelsCompliances->Code;

                $seedQty = $class->Compliances->$code->seedQty;
                $class->Compliances->$code->model::factory($seedQty)->create();

            }
        }



        if(!User::get()->count()) User::factory(1)->create();

        if(!SettingTheme::first()){
            $this->call([
                SettingThemeSeeder::class,
            ]);
        }

        if(!SettingSmtp::first()){
            $this->call([
                SettingSmtpSeeder::class,
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

        if(!CallToActionTitle::first()){
            $this->call([
                CallToActionTitleSeeder::class,
            ]);
        }
    }
}
