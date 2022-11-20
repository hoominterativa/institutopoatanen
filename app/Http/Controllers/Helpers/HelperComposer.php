<?php

use Cohensive\Embed\Facades\Embed;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

if(!function_exists('isActive')){
    function isActive($href, $class = 'active'){
        return $class = (strpos(Route::currentRouteName(),$href) === 0 ? $class : '');
    }
}

if(!function_exists('storageDelete')){
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

if(!function_exists('conveterOembedCKeditor')){
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
