<?php

namespace App\Http\Controllers\ContentPages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA01ContentPagesSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class COPA01SectionController extends Controller
{
    protected $path = 'uploads/ContentPages/COPA01/images/';

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        if($request->active_banner) $data['active_banner'] = $request->active_banner?1:0;
        if($request->active_section) $data['active_section'] = $request->active_section?1:0;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if($request->active_banner) $data['active_banner'] = $request->active_banner?1:0;
        if($request->active_section) $data['active_section'] = $request->active_section?1:0;

        if(COPA01ContentPagesSection::create($data)){
            Session::flash('success', 'Seção cadastrada com sucesso');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);

            Session::flash('error', 'Erro ao cadastradar a seção');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentPages\COPA01ContentPagesSection  $COPA01ContentPagesSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COPA01ContentPagesSection $COPA01ContentPagesSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        if($request->active_banner) $data['active_banner'] = $request->active_banner?1:0;
        if($request->active_section) $data['active_section'] = $request->active_section?1:0;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if($path_image_desktop){
            storageDelete($COPA01ContentPagesSection, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($COPA01ContentPagesSection, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if($path_image_mobile){
            storageDelete($COPA01ContentPagesSection, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($COPA01ContentPagesSection, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        if($COPA01ContentPagesSection->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }
}
