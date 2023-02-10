<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Social;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class GeneralSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $GeneralSetting =  GeneralSetting::first();

        $linksCtaHeader = json_decode($GeneralSetting->btn_cta_header);
        $linksCtaFooter = json_decode($GeneralSetting->btn_cta_footer);

        return view('Admin.cruds.generalSetting.edit', [
            'generalSetting' => $GeneralSetting,
            'linksCtaHeader' => $linksCtaHeader,
            'linksCtaFooter' => $linksCtaFooter,
            'socials' => Social::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GeneralSetting  $GeneralSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GeneralSetting $GeneralSetting)
    {
        $path = 'uploads/images/generalSetting/';
        $helper = new HelperArchive();
        $data = $request->all();

        $path_logo_header_light = $helper->optimizeImage($request, 'path_logo_header_light', $path, null,100);
        $path_logo_header_dark = $helper->optimizeImage($request, 'path_logo_header_dark', $path, null,100);
        $path_logo_footer_light = $helper->optimizeImage($request, 'path_logo_footer_light', $path, null,100);
        $path_logo_footer_dark = $helper->optimizeImage($request, 'path_logo_footer_dark', $path, null, 100);
        $path_logo_share = $helper->optimizeImage($request, 'path_logo_share', $path, null,100);
        $path_favicon = $helper->optimizeImage($request, 'path_favicon', $path, null,100);

        if($path_logo_header_light){
            storageDelete($GeneralSetting, 'path_logo_header_light');
            $data["path_logo_header_light"] = $path_logo_header_light;
        }
        if($path_logo_header_dark){
            storageDelete($GeneralSetting, 'path_logo_header_dark');
            $data["path_logo_header_dark"] = $path_logo_header_dark;
        }

        if($path_logo_footer_light){
            storageDelete($GeneralSetting, 'path_logo_footer_light');
            $data["path_logo_footer_light"] = $path_logo_footer_light;
        }
        if($path_logo_footer_dark){
            storageDelete($GeneralSetting, 'path_logo_footer_dark');
            $data["path_logo_footer_dark"] = $path_logo_footer_dark;
        }

        if($path_logo_share){
            storageDelete($GeneralSetting, 'path_logo_share');
		    $data["path_logo_share"] = $path_logo_share;
        }

        if($path_favicon){
            storageDelete($GeneralSetting, 'path_favicon');
		    $data["path_favicon"] = $path_favicon;
        }

        if($GeneralSetting->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucessso');
            return redirect()->back();
        }else{
            Storage::delete($path_logo_header_light);
            Storage::delete($path_logo_header_dark);
            Storage::delete($path_logo_footer_light);
            Storage::delete($path_logo_footer_dark);
            Storage::delete($path_logo_share);
            Storage::delete($path_favicon);

            Session::flash('error', 'Erro ao atualizar informações');
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GeneralSetting  $GeneralSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(GeneralSetting $GeneralSetting)
    {
        if($GeneralSetting->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }

    public function linksHeader(Request $request, GeneralSetting $GeneralSetting)
    {
        $data = [];
        foreach ($request->title_btn_cta as $key => $title) {
            $merge = [
                'title' => $request->title_cta_btn,
                $title => [$request->link_btn_cta[$key], $request->link_target[$key]]
            ];

            $data = array_merge($data, $merge);
        }

        if($GeneralSetting->fill(['btn_cta_header' => json_encode($data)])->save()){
            Session::flash('success', 'Links cadastrados com sucessso');
            Session::flash('reopenModal', 'modal-links-cta-header-create');
            return redirect()->back();
        }
    }

    public function linksFooter(Request $request, GeneralSetting $GeneralSetting)
    {
        $data = [];
        foreach ($request->title_btn_cta as $key => $title) {
            $merge = [
                'title' => $request->title_cta_btn,
                $title => [$request->link_btn_cta[$key], $request->link_target[$key]]
            ];

            $data = array_merge($data, $merge);
        }

        if($GeneralSetting->fill(['btn_cta_footer' => json_encode($data)])->save()){
            Session::flash('success', 'Links cadastrados com sucessso');
            Session::flash('reopenModal', 'modal-links-cta-footer-create');
            return redirect()->back();
        }
    }
}
