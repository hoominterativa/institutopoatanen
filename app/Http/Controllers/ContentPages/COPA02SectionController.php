<?php

namespace App\Http\Controllers\ContentPages;

use App\Models\ContentPages\COPA02ContentPagesSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COPA02SectionController extends Controller
{
    protected $path = 'uploads/ContentPages/COPA02/images/';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA02.Section.create', [
            'cropSetting' => getCropImage('ContentPages', 'COPA02')
        ]);
    }

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

        $data['active'] = $request->active?1:0;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if(COPA02ContentPagesSection::create($data)){
            Session::flash('success', 'Seção cadastrada com sucesso');
            return redirect()->route('admin.copa02.index');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar a seção');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContentPages\COPA02ContentPagesSection  $COPA02ContentPagesSection
     * @return \Illuminate\Http\Response
     */
    public function edit(COPA02ContentPagesSection $COPA02ContentPagesSection)
    {
        return view('Admin.cruds.ContentPages.COPA02.Section.edit', [
            'section' => $COPA02ContentPagesSection,
            'cropSetting' => getCropImage('ContentPages', 'COPA02')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentPages\COPA02ContentPagesSection  $COPA02ContentPagesSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COPA02ContentPagesSection $COPA02ContentPagesSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop){
            storageDelete($COPA02ContentPagesSection, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($COPA02ContentPagesSection, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile){
            storageDelete($COPA02ContentPagesSection, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($COPA02ContentPagesSection, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        if($COPA02ContentPagesSection->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentPages\COPA02ContentPagesSection  $COPA02ContentPagesSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(COPA02ContentPagesSection $COPA02ContentPagesSection)
    {
        storageDelete($COPA02ContentPagesSection, 'path_image_desktop');
        storageDelete($COPA02ContentPagesSection, 'path_image_mobile');

        if($COPA02ContentPagesSection->delete()){
            Session::flash('success', 'Seção deletada com sucessso');
            return redirect()->back();
        }
    }

    /**
     * Remove the selected resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request)
    {
        $COPA02ContentPagesSections = COPA02ContentPagesSection::whereIn('id', $request->deleteAll)->get();
        foreach($COPA02ContentPagesSections as $COPA02ContentPagesSection){
            storageDelete($COPA02ContentPagesSection, 'path_image_desktop');
            storageDelete($COPA02ContentPagesSection, 'path_image_mobile');
        }

        if($deleted = COPA02ContentPagesSection::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Seções deletadas com sucessso']);
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
            COPA02ContentPagesSection::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
