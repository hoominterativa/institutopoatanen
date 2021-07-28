<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;

class HelperPublishing extends Controller
{
    public function createScssApp()
    {
        $createArchive = new HelperArchive();
        $coreConfig = config('modelsConfig.InsertModelsCore');
        $content = "@import 'config';\n@import 'fonts';\n";
        foreach ($coreConfig as $module => $code) {
            $content .= "@import '../../Core/{$module}/{$code->Code}/src/main';\n";
        }
        $return = $createArchive->createArchive('resources/views/Client/assets/scss/base.scss', $content);

        if($return){
            return true;
        }
        return false;
    }
}
