<?php

namespace App\Http\Controllers;

use App\Models\SettingTheme;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setting(Request $request)
    {
        $settingTheme = SettingTheme::where('user_id', Auth::user()->id)->first();
        if(!$settingTheme){
            $settingTheme = new SettingTheme();
        }

        $settingTheme->color_scheme_mode = $request->color_scheme_mode;
        $settingTheme->leftsidebar_color = $request->leftsidebar_color;
        $settingTheme->leftsidebar_size = $request->leftsidebar_size;
        $settingTheme->topbar_color = $request->topbar_color;
        $settingTheme->save();
    }

}
