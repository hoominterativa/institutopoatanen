<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class HelperModule extends Controller
{
    protected $arrayModule;

    public function __construct()
    {
        $this->arrayModule = json_decode(file_get_contents("modules.json"), true);
    }

    /**
     * Search a module or model in archive modules.json
     *
     * @param string $module
     * @param string $code
     *
     * @return string|boolean
     */

    public function searchModulesJson($module='', $code='')
    {
        $response = "Módulo ou modelo inválido";

        if($module<>'' && $code==''){
            $response = array_key_exists($module, $this->arrayModule);
        }
        if($module<>'' && $code<>''){
            $response = in_array($code, $this->arrayModule[$module]);
        }

        return $response;
    }

    /**
     * Register a new module or model in archive modules.json
     *
     * @param string $module
     * @param string $code
     *
     * @return string
     */

    public function refreshModulesJson($module='', $code='')
    {
        if($module<>'' && $code==''){
            if(!$this->searchModulesJson($module)){
                $new = [$module=>[]];
                $this->arrayModule = array_merge($this->arrayModule, $new);
            }
        }

        if($module<>null && $code<>null){
            if(!$this->searchModulesJson($module, $code)){
                array_push($this->arrayModule[$module], ...[$code]);
            };
        }

        $newJson = json_encode($this->arrayModule, JSON_PRETTY_PRINT);

        $file = fopen('modules.json','w');
        $written = fwrite($file, $newJson);
        fclose($file);

        return $written;
    }

    /**
     * List all or a module and its models
     *
     * @param string $module
     *
     * @return string|array
     */

    public function listModules($module='')
    {
        $validate = $this->searchModulesJson($module);
        if(!$validate) return "Módulo inválido";

        if($module<>'') $this->arrayModule = [$module => $this->arrayModule[$module]];

        return $this->arrayModule;
    }
}
