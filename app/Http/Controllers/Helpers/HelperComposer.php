<?php

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
