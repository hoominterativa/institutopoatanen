<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use Exception;

class HelperPublishing extends Controller
{
    public function createScssApp()
    {
        try{
            $createArchive = new HelperArchive();
            $coreConfig = config('modelsConfig.InsertModelsCore');
            $contentScss = "@import 'variables';\n@import 'config';\n@import 'fonts';\n";
            $contentJs="";
            foreach ($coreConfig as $module => $code) {
                $codeIf = (array) $code;
                if(count($codeIf)){
                    $contentScss .= "@import '../../Core/{$module}/{$code->Code}/src/main';\n";
                    $contentScss .= "@import '../../Core/{$module}/{$code->Code}/src/variables';\n";
                    $contentJs .= "import '../../Core/{$module}/{$code->Code}/src/main';\n";
                }
            }

            $mainConfig = config('modelsConfig.InsertModelsMain');
            foreach ($mainConfig as $module => $models) {
                foreach ($models as $code => $config) {
                    $contentScss .= "@import '../../pages/{$module}/{$code}/src/main';\n";
                    $contentJs .= "import '../../pages/{$module}/{$code}/src/main';\n";
                }
            }

            $createArchive->createArchive('resources/views/Client/assets/scss/base.scss', $contentScss);
            $createArchive->createArchive('resources/views/Client/assets/js/base.js', $contentJs);

            return true;
        }catch(Exception $e){
            return $e;
        }
    }
}
