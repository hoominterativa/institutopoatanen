<?php

use Carbon\Carbon;
use Detection\MobileDetect;
use Illuminate\Support\Str;
use Cohensive\Embed\Facades\Embed;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CoreController;

if (!function_exists('isActive')) {
    function isActive($href, $class = 'active')
    {
        return $class = (strpos(Route::currentRouteName(), $href) !== false ? $class : '');
    }
}

if (!function_exists('dateFormat')) {
    /**
     * Returns the date formatted according to the specified format.
     *
     * @param string $date -
     * @param string $day "D" - day name | "d" - day number
     * @param string $month "M" - month name | "m" - month number
     * @param string $year "Y" - full year | "y" - abbreviated year
     * @param string $split inform which character will be used in date formatting, white equals space and include "de"
     *
     * @return string
     */
    function dateFormat($date, $day = 'd', $month = 'm', $year = 'Y', $split = '/')
    {
        $dayWeek = date("N", strtotime($date));
        $arrayDay = ['1' => 'Segunda-Feira', '2' => 'Terça-Feira', '3' => 'Quarta-Feira', '4' => 'Quinta-Feira', '5' => 'Sexta-Feira', '6' => 'Sábado', '7' => 'Domingo'];
        $arrayMonth = ['01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril', '05' => 'Maio', '06' => 'Junho', '07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro'];

        $dayN = ($day === 'D' ? $arrayDay[$dayWeek] : Carbon::parse($date)->format('d'));
        $monthN = ($month === 'M' ? $arrayMonth[Carbon::parse($date)->format('m')] : Carbon::parse($date)->format('m'));
        $yearN = Carbon::parse($date)->format($year);

        if ($split <> '') {
            $dateFormatted = $dayN . $split . $monthN . $split . $yearN;
        } else {
            $dateFormatted = $dayN . ' de ' . $monthN . ' de ' . $yearN;
        }

        return $dateFormatted;
    }
}

if (!function_exists('dayFull')) {
    function dayFull($date)
    {
        $diasDaSemana = [
            'Sun' => 'Domingo',
            'Mon' => 'Segunda-feira',
            'Tue' => 'Terça-feira',
            'Wed' => 'Quarta-feira',
            'Thu' => 'Quinta-feira',
            'Fri' => 'Sexta-feira',
            'Sat' => 'Sábado',
        ];

        $dia = date('D', $date);

        if (array_key_exists($dia, $diasDaSemana)) {
            return $diasDaSemana[$dia];
        }

        return 'Dia não encontrado';
    }
}

if (!function_exists('monthFull')) {
    function monthFull($date)
    {
        $mesDoAno = [
            'Jan' => 'Janeiro',
            'Feb' => 'Fevereiro',
            'Mar' => 'Março',
            'Apr' => 'Abril',
            'May' => 'Maio',
            'Jun' => 'Junho',
            'Jul' => 'Julho',
            'Aug' => 'Agosto',
            'Sep' => 'Setembro',
            'Oct' => 'Outubro',
            'Nov' => 'Novembro',
            'Dec' => 'Dezembro',
        ];


        $mes = date('M', $date);

        if (array_key_exists($mes, $mesDoAno)) {
            return $mesDoAno[$mes];
        }

        return 'Mês não encontrado';
    }
}

if (!function_exists('storageDelete')) {
    /**
     * Delete files the storage
     *
     * @param \App\Models $query
     * @param string $column
     *
     * @return \Illuminate\Http\Response
     */
    function storageDelete($query, $column)
    {
        if (mb_strpos($query->$column, 'tmp') === false) {
            return Storage::delete($query->$column);
        }
        return null;
    }
}

if (!function_exists('conveterOembedCKeditor')) {
    function conveterOembedCKeditor($text)
    {
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
            $iframe = '<div style="position: relative; padding-bottom: 100%; height: 0; padding-bottom: 56.2493%;">' . $getHtml . '</div>';
            $text = str_replace('<oembed url="' . $urlOembed . '"></oembed>', $iframe, $text);
        }
        return $text;
    }
}
if (!function_exists('getCompliance')) {

    /**
     * Delete files the storage
     *
     * @param int $id
     * @param int $idR Id Reference for pluck
     * @param int $title Title Reference for pluck
     *
     * @return \Illuminate\Http\Response
     */
    function getCompliance($id = null, $idR = null, $title = null)
    {
        $ModelsCompliances = config('modelsConfig.ModelsCompliances');
        $class = config('modelsClass.Class');
        $complianceModel = null;

        if (isset($ModelsCompliances->Code)) {
            if ($ModelsCompliances->Code <> '') {
                $code = $ModelsCompliances->Code;
                $name = Str::slug($code);
                $param = $code . 'Compliances';

                if ($id <> null) {
                    $complianceModel = $class->Compliances->$code->model::find($id);
                    if ($complianceModel) {
                        $complianceModel->link = route($name . '.show', [$param => $complianceModel->slug]);
                    }
                } else {
                    if ($idR || $title) {
                        $complianceModel = $class->Compliances->$code->model::sorting()->pluck($title, $idR);
                    } else {
                        $complianceModel = $class->Compliances->$code->model::sorting()->get();
                        foreach ($complianceModel as $compliance) {
                            $compliance->link = route($name . '.show', [$param => $compliance->slug]);
                        }
                    }
                }
            }
        }

        return $complianceModel;
    }
}

if (!function_exists('clearVersionNameModule')) {

    /**
     * clear a number the name module
     *
     * @param string $module
     *
     * @return string
     */
    function clearVersionNameModule($module)
    {
        $arrayName = explode('.', $module);
        return $arrayName[0];
    }
}

if (!function_exists('getNameModule')) {

    /**
     * Get module name when this is a versioned array
     *
     * @param object $modelConfig
     * @param string $module
     * @param string $model
     *
     * @return string
     */
    function getNameModule($modelConfig, $module, $model)
    {
        foreach ($modelConfig as $name => $value) {
            $arrayName = explode('.', $name);
            if (count($arrayName) > 1) {
                if ($arrayName[0] == $module) {
                    if (isset($modelConfig->$name->$model)) {
                        return $name;
                    }
                }
            }
        }
        return $module;
    }
}

if (!function_exists('getTitleModel')) {

    /**
     * Get model name
     *
     * @param object $modelConfig
     * @param string $module
     * @param string $model
     *
     * @return string
     */
    function getTitleModel($modelConfig, $module, $model)
    {
        foreach ($modelConfig as $name => $value) {
            $arrayName = explode('.', $name);
            if (count($arrayName) > 1) {
                if ($arrayName[0] == $module) {
                    if (isset($modelConfig->$name->$model)) {
                        return $modelConfig->$name->$model->config->titlePanel;
                    }
                }
            }
        }
        return $modelConfig->$module->$model->config->titlePanel;
    }
}

if (!function_exists('getCropImage')) {

    /**
     * Get image cropping dimensions
     *
     * @param string $module
     * @param string $model
     * @param string $column
     * @param string $submodel
     *
     * @return array
     */
    function getCropImage($module, $model, $column = null, $submodel = null)
    {
        $settingCropImages = json_decode(file_get_contents("../imagesSize.json"), true);
        $getModule = $settingCropImages[$module];
        $getModel = $getModule[$model];

        if (!$column) {
            $response = json_encode($getModel);
            return json_decode($response);
        }

        $getColumn = $getModel[$column];
        if ($submodel) $getColumn = $getModel[$submodel][$column];

        $response = json_encode($getColumn);
        return json_decode($response);
    }
}

if (!function_exists('getUri')) {

    /**
     * Get uri
     *
     * @param string $url
     * @return array
     */

    function getUri($url)
    {
        if ($url) {
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                $parseUrl = parse_url($url);
                $parseUrlCurrent = parse_url(url()->current());

                if ($parseUrl['host'] === $parseUrlCurrent['host']) {
                    $fragment = isset($parseUrl['fragment']) ? '#' . $parseUrl['fragment'] : '';
                    $query = isset($parseUrl['query']) ? '?' . $parseUrl['query'] : '';

                    $urlPath = $parseUrl['path'] ?? '';
                    $arrayUrlPath = explode('/', $urlPath);

                    if (strpos($urlPath, '_website') !== false) {
                        $firstPathRemove = $arrayUrlPath[array_search('_website', $arrayUrlPath)];
                        $lastPathRemove = $arrayUrlPath[(array_search('_website', $arrayUrlPath)) + 1];
                        $urlPath = str_replace([$firstPathRemove . '/', $lastPathRemove . '/'], '', $urlPath);
                    }

                    return $urlPath . $query . $fragment;
                } else {
                    return $url;
                }
            } else {
                return url($url);
            }
        } else {
            return null;
        }
    }
}

if (!function_exists('listPage')) {

    /**
     * List pages website inner
     *
     * @param string $return [registers, relations, pages]
     * @return object
     */
    function listPage($return = 'registers')
    {
        $core = new CoreController();
        $pages = [];
        $modelsMain = config('modelsConfig.InsertModelsMain');
        switch ($return) {
            case 'registers':
                foreach ($modelsMain as $module => $models) {
                    foreach ($models as $code => $config) {
                        if ($config->ViewListMenu) {
                            $registers = $core->getRelations($module, $code, $config);
                            $merge = [
                                'title' => $config->config->titleMenu,
                                'route' => $config->config->anchor ? url('/').'/'.$config->config->linkMenu : route($config->config->linkMenu),
                                'dropdown' => $registers
                            ];
                            array_push($pages, $merge);
                        }
                    }
                }
                break;
            case 'relations':
                foreach ($modelsMain as $module => $models) {
                    foreach ($models as $code => $config) {
                        if ($config->ViewListMenu) {
                            $registers = $core->getRelations($module, $code, $config, $return);

                            $merge = [
                                'title' => $config->config->titleMenu,
                                'module' => $module,
                                'model' => $code,
                                'relations' => $registers
                            ];
                            array_push($pages, $merge);
                        }
                    }
                }
                break;
            case 'pages':
                foreach ($modelsMain as $module => $models) {
                    foreach ($models as $code => $config) {

                        if ($config->ViewListMenu) {
                            $merge = [
                                $module . '|' . $code => $config->config->titleMenu,
                            ];
                            $pages = array_merge($pages, $merge);
                        }

                        if (isset($config->pages)) {
                            if (count(get_object_vars($config->pages))) {
                                foreach ($config->pages as $key => $page) {

                                    $merge = [
                                        $module . '|' . $code . '|' . $key => $page->name,
                                    ];
                                    $pages = array_merge($pages, $merge);
                                }
                            }
                        }
                    }
                }
                return $pages;
                break;
        }

        $pages = json_encode($pages);
        return json_decode($pages);
    }
}

if (!function_exists('deviceDetect')) {

    /**
     * Device detect
     *
     * @return object
     */
    function deviceDetect()
    {
        $detect = new MobileDetect();
        if ($detect->isMobile()) return 'mobile';
        if ($detect->isTablet()) return 'tablet';
        return 'desktop';
    }
}


if (!function_exists('getCondition')) {

    /**
     * Get Conditions for build header
     *
     * @param string $module
     * @param string $code
     * @param integer $condition
     * @param string $relation
     * @return void|string
     */
    function getCondition($module, $code, $condition = null, $relation = null)
    {
        $modelsMain = config('modelsConfig.InsertModelsMain');
        if (isset($modelsMain->$module->$code->IncludeCore->condition)) {
            if ($condition !== null) {
                $arrCondition = explode(',', $modelsMain->$module->$code->IncludeCore->condition);
                $splitCondition = str_replace('}', '', explode('{', $arrCondition[$condition]));
                return $splitCondition[1];
            } else {
                $arrCondition = explode(',', $modelsMain->$module->$code->IncludeCore->condition);
                if ($relation) $arrCondition = explode(',', $modelsMain->$module->$code->IncludeCore->relation->$relation->condition);

                $conditions = [];
                foreach ($arrCondition as $value) {
                    $splitCondition = str_replace('}', '', explode('{', $value));
                    $conditions = array_merge($conditions, [$splitCondition[1]]);
                }
                return $conditions;
            }
        }
        return;
    }
}

if (!function_exists('getNameRelation')) {

    /**
     * Get name relationship for cuild header
     *
     * @param string $module
     * @param string $code
     * @param string $relation
     * @return void|string
     */
    function getNameRelation($module, $code, $relation, $page = '')
    {
        $modelsMain = config('modelsConfig.InsertModelsMain');
        if (isset($modelsMain->$module->$code->IncludeCore->relation)) {
            $name = $page;
            $splitRelation = explode(',', $relation);

            if ($splitRelation[0] <> 'this') {
                $arrRelation = $modelsMain->$module->$code->IncludeCore->relation;

                if ($arrRelation <> '') {
                    $refName = $splitRelation[0];
                    $name = $arrRelation->$refName->name;

                    if (count($splitRelation) > 1) {
                        $refName = $splitRelation[1];
                        $name .= ' / ' . $arrRelation->$refName->name;
                    }
                }
            }
            return $name;
        }
        return $page;
    }
}

if (!function_exists('listRelations')) {

    /**
     * Get relationship
     *
     * @param string $module
     * @param string $code
     * @return array
     */
    function getRelationsModel($module, $code, $page = null)
    {
        $modelsMain = config('modelsConfig.InsertModelsMain');
        if (!$page) {
            if (isset($modelsMain->$module->$code->IncludeCore->relation)) {
                $arrRelations[$modelsMain->$module->$code->config->titleMenu] = [];
                if ($modelsMain->$module->$code->IncludeCore->relation) {
                    foreach ($modelsMain->$module->$code->IncludeCore->relation as $relation => $configRelation) {
                        $merge = [
                            $relation => $configRelation->name
                        ];
                        $arrRelations[$modelsMain->$module->$code->config->titleMenu] = array_merge($arrRelations[$modelsMain->$module->$code->config->titleMenu], $merge);
                    }
                }
                return $arrRelations;
            }
        }
        return;
    }
}
