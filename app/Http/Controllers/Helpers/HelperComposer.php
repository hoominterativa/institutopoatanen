<?php

use Illuminate\Support\Str;
use Cohensive\Embed\Facades\Embed;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

if(!function_exists('isActive'))
{
    function isActive($href, $class = 'active'){
        return $class = (strpos(Route::currentRouteName(),$href) === 0 ? $class : '');
    }
}

if(!function_exists('storageDelete'))
{
    /**
     * Delete files the storage
     *
     * @param \App\Models $query
     * @param string $column
     *
     * @return \Illuminate\Http\Response
     */
    function storageDelete($query, $column){
        if(mb_strpos($query->$column, 'tmp') === false){
            return Storage::delete($query->$column);
        }
        return null;
    }
}

if(!function_exists('conveterOembedCKeditor'))
{
   function conveterOembedCKeditor($text){
        $oembeds = explode('<oembed url="', $text);
        unset($oembeds[0]);
        foreach ($oembeds as $oembed) {
            $urlOembed = explode('"', $oembed)[0];

            $embed = Embed::make($urlOembed)->parseUrl();
            $embed->setAttribute([
                'width' => '100%',
                'height' => '100%',
                'style' => 'position: absolute',
                'top' => 0,
                'left' => 0,
            ]);

            $getHtml = $embed->getHtml();
            $iframe = '<div style="position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;">'.$getHtml.'</div>';
            $text = str_replace('<oembed url="'.$urlOembed.'"></oembed>',$iframe, $text);
        }
        return $text;
   }
}
if(!function_exists('getCompliance')){

    /**
     * Delete files the storage
     *
     * @param int $id
     * @param int $idR Id Reference for pluck
     * @param int $title Title Reference for pluck
     *
     * @return \Illuminate\Http\Response
     */
    function getCompliance($id=null, $idR=null, $title=null)
    {
        $ModelsCompliances = config('modelsConfig.ModelsCompliances');
        $class = config('modelsClass.Class');
        $complianceModel = null;

        if(isset($ModelsCompliances->Code)){
            if($ModelsCompliances->Code <> ''){
                $code = $ModelsCompliances->Code;
                $name = Str::slug($code);
                $param = $code.'Compliances';

                if($id<>null){
                    $complianceModel = $class->Compliances->$code->model::find($id);
                    if($complianceModel){
                        $complianceModel->link = route($name.'.show', [$param => $complianceModel->slug]);
                    }
                }else{
                    if($idR || $title){
                        $complianceModel = $class->Compliances->$code->model::sorting()->pluck($title, $idR);
                    }else{
                        $complianceModel = $class->Compliances->$code->model::sorting()->get();
                        foreach ($complianceModel as $compliance) {
                            $compliance->link = route($name.'.show', [$param => $compliance->slug]);
                        }
                    }
                }
            }
        }

        return $complianceModel;
    }
}

if(!function_exists('getNameModule')){

    /**
     * Get module name when this is a versioned array
     *
     * @param object $modelConfig
     * @param string $module
     * @param string $model
     *
     * @return string
     */
    function getNameModule($modelConfig, $module, $model){
        foreach ($modelConfig as $name => $value) {
            $arrayName = explode('.', $name);
            if(count($arrayName)>1){
                if($arrayName[0]==$module){
                    if(isset($modelConfig->$name->$model)){
                        return $name;
                    }
                }
            }
        }
        return $module;
    }
}

if(!function_exists('getTitleModel')){

    /**
     * Get model name
     *
     * @param object $modelConfig
     * @param string $module
     * @param string $model
     *
     * @return string
     */
    function getTitleModel($modelConfig, $module, $model){
        foreach ($modelConfig as $name => $value) {
            $arrayName = explode('.', $name);
            if(count($arrayName)>1){
                if($arrayName[0]==$module){
                    if(isset($modelConfig->$name->$model)){
                        return $modelConfig->$name->$model->config->titlePanel;
                    }
                }
            }
        }
        return $modelConfig->$module->$model->config->titlePanel;
    }
}
