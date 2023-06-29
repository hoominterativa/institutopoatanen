<?php

namespace App\Http\Controllers\Products;

use App\Models\Products\PROD05ProductsSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class PROD05SectionController extends Controller
{
    protected $path = 'uploads/Porducts/PROD05/images/';

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sectionStore(Request $request)
    {
        $PROD05ProductsSection = new PROD05ProductsSection();

        $PROD05ProductsSection->title = $request->title;
        $PROD05ProductsSection->subtitle = $request->subtitle;
        $PROD05ProductsSection->description = $request->description;

        if($PROD05ProductsSection->save()){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products\PROD05ProductsSection  $PROD05ProductsSection
     * @return \Illuminate\Http\Response
     */
    public function sectionUpdate(Request $request, PROD05ProductsSection $PROD05ProductsSection)
    {
        $PROD05ProductsSection->title = $request->title;
        $PROD05ProductsSection->subtitle = $request->subtitle;
        $PROD05ProductsSection->description = $request->description;
        $PROD05ProductsSection->active = $request->active?1:0;

        if($PROD05ProductsSection->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bannerStore(Request $request)
    {
        $helper = new HelperArchive();

        $PROD05ProductsSection = new PROD05ProductsSection();

        $path_image_banner = $helper->optimizeImage($request, 'path_image_banner', $this->path, null,100);
        if($path_image_banner) $PROD05ProductsSection->path_image_banner = $path_image_banner;

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null,100);
        if($path_image_banner_mobile) $PROD05ProductsSection->path_image_banner_mobile = $path_image_banner_mobile;

        $PROD05ProductsSection->title_banner = $request->title_banner;
        $PROD05ProductsSection->subtitle_banner = $request->subtitle_banner;

        if($PROD05ProductsSection->save()){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Storage::delete($path_image_banner);
            Storage::delete($path_image_banner_mobile);
            Session::flash('error', 'Erro ao cadastradar informações');
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products\PROD05ProductsSection  $PROD05ProductsSection
     * @return \Illuminate\Http\Response
     */
    public function bannerUpdate(Request $request, PROD05ProductsSection $PROD05ProductsSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_banner = $helper->optimizeImage($request, 'path_image_banner', $this->path, null,100);
        if($path_image_banner){
            storageDelete($PROD05ProductsSection, 'path_image_banner');
            $PROD05ProductsSection->path_image_banner = $path_image_banner;
        }
        if($request->delete_path_image_banner && !$path_image_banner){
            storageDelete($PROD05ProductsSection, 'path_image_banner');
            $PROD05ProductsSection->path_image_banner = null;
        }

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null,100);
        if($path_image_banner_mobile){
            storageDelete($PROD05ProductsSection, 'path_image_banner_mobile');
            $PROD05ProductsSection->path_image_banner_mobile = $path_image_banner_mobile;
        }
        if($request->delete_path_image_banner_mobile && !$path_image_banner_mobile){
            storageDelete($PROD05ProductsSection, 'path_image_banner_mobile');
            $PROD05ProductsSection->path_image_banner_mobile = null;
        }

        $PROD05ProductsSection->title_banner = $request->title_banner;
        $PROD05ProductsSection->subtitle_banner = $request->subtitle_banner;

        if($PROD05ProductsSection->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image_banner);
            Storage::delete($path_image_banner_mobile);
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }
}
