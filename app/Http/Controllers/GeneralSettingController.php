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
        return view('Admin.cruds.generalSetting.edit', [
            'generalSetting' => GeneralSetting::first(),
            'socials' => Social::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Session::flash('success', 'Item cadastrado com sucessso');
        return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GeneralSetting  $GeneralSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(GeneralSetting $GeneralSetting)
    {
        //
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
        $helperArchive = new HelperArchive();
        $path_logo_header_light = $helperArchive->renameArchiveUpload($request, 'path_logo_header_light');
        $path_logo_header_dark = $helperArchive->renameArchiveUpload($request, 'path_logo_header_dark');
        $path_logo_footer_light = $helperArchive->renameArchiveUpload($request, 'path_logo_footer_light');
        $path_logo_footer_dark = $helperArchive->renameArchiveUpload($request, 'path_logo_footer_dark');
        $path_logo_share = $helperArchive->renameArchiveUpload($request, 'path_logo_share');
        $path_favicon = $helperArchive->renameArchiveUpload($request, 'path_favicon');

        if($path_logo_header_light){
            Storage::delete($GeneralSetting->path_logo_header_light);
            $GeneralSetting->path_logo_header_light = $path.$path_logo_header_light;
            $request->path_logo_header_light->storeAs($path, $path_logo_header_light);
        }
        if($path_logo_header_dark){
            Storage::delete($GeneralSetting->path_logo_header_dark);
            $GeneralSetting->path_logo_header_dark = $path.$path_logo_header_dark;
            $request->path_logo_header_dark->storeAs($path, $path_logo_header_dark);
        }

        if($path_logo_footer_light){
            Storage::delete($GeneralSetting->path_logo_footer_light);
            $GeneralSetting->path_logo_footer_light = $path.$path_logo_footer_light;
            $request->path_logo_footer_light->storeAs($path, $path_logo_footer_light);
        }
        if($path_logo_footer_dark){
            Storage::delete($GeneralSetting->path_logo_footer_dark);
            $GeneralSetting->path_logo_footer_dark = $path.$path_logo_footer_dark;
            $request->path_logo_footer_dark->storeAs($path, $path_logo_footer_dark);
        }

        if($path_logo_share){
            Storage::delete($GeneralSetting->path_logo_share);
		    $GeneralSetting->path_logo_share = $path.$path_logo_share;
            $request->path_logo_share->storeAs($path, $path_logo_share);
        }

        if($path_favicon){
            Storage::delete($GeneralSetting->path_favicon);
		    $GeneralSetting->path_favicon = $path.$path_favicon;
            $request->path_favicon->storeAs($path, $path_favicon);
        }

		$GeneralSetting->phone = $request->phone;
		$GeneralSetting->whatsapp = $request->whatsapp;
		$GeneralSetting->address = $request->address;
		$GeneralSetting->smtp_host = $request->smtp_host;
		$GeneralSetting->smtp_port = $request->smtp_port;
		$GeneralSetting->smtp_user = $request->smtp_user;
		$GeneralSetting->smtp_password = $request->smtp_password;
        $GeneralSetting->save();

        Session::flash('success', 'Informações atualizadas com sucessso');
        return redirect()->back();
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

    /**
     * Remove the selected resource from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request)
    {
        if($deleted = GeneralSetting::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
        }
    }
    /**
    * Sort record by dragging and dropping
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id){
            GeneralSetting::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\GeneralSetting  $GeneralSetting
     * @return \Illuminate\Http\Response
     */
    public function show(GeneralSetting $GeneralSetting)
    {
        //
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        //
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        return view('');
    }
}
