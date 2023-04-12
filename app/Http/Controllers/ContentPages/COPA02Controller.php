<?php

namespace App\Http\Controllers\ContentPages;

use App\Models\ContentPages\COPA02ContentPages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA02ContentPagesSectionContent;

class COPA02Controller extends Controller
{
    protected $path = 'uploads/ContentPages/COPA02/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = COPA02ContentPages::sorting()->paginate(15);
        $sectionContent = COPA02ContentPagesSectionContent::first();
        return view('Admin.cruds.ContentPages.COPA02.index', [
            'contents' => $contents,
            'sectionContent' => $sectionContent,
            'cropSetting' => getCropImage('ContentPages', 'COPA02')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA02.create', [
            'cropSetting' => getCropImage('ContentPages', 'COPA02'),
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

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if(COPA02ContentPages::create($data)){
            Session::flash('success', 'Página de conteúdo cadastrada com sucesso');
            return redirect()->route('admin.copa02.index');
        }else{
            Storage::delete($path_image_box);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar a página de conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContentPages\COPA02ContentPages  $COPA02ContentPages
     * @return \Illuminate\Http\Response
     */
    public function edit(COPA02ContentPages $COPA02ContentPages)
    {
        return view('Admin.cruds.ContentPages.COPA02.edit', [
            'content' => $COPA02ContentPages,
            'cropSetting' => getCropImage('ContentPages', 'COPA02'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentPages\COPA02ContentPages  $COPA02ContentPages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COPA02ContentPages $COPA02ContentPages)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box){
            storageDelete($COPA02ContentPages, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($COPA02ContentPages, 'path_image_box');
            $data['path_image_box'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($COPA02ContentPages, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($COPA02ContentPages, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop){
            storageDelete($COPA02ContentPages, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($COPA02ContentPages, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile){
            storageDelete($COPA02ContentPages, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($COPA02ContentPages, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        if($COPA02ContentPages->fill($data)->save()){
            Session::flash('success', 'Página de conteúdo atualizada com sucesso');
        }else{
            Storage::delete($path_image_box);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar a página de conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentPages\COPA02ContentPages  $COPA02ContentPages
     * @return \Illuminate\Http\Response
     */
    public function destroy(COPA02ContentPages $COPA02ContentPages)
    {
        storageDelete($COPA02ContentPages, 'path_image_box');
        storageDelete($COPA02ContentPages, 'path_image_icon');
        storageDelete($COPA02ContentPages, 'path_image_desktop');
        storageDelete($COPA02ContentPages, 'path_image_mobile');

        if($COPA02ContentPages->delete()){
            Session::flash('success', 'Página de conteúdo deletada com sucessso');
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
        $COPA02ContentPagess = COPA02ContentPages::whereIn('id', $request->deleteAll)->get();
        foreach($COPA02ContentPagess as $COPA02ContentPages){
            storageDelete($COPA02ContentPages, 'path_image_box');
            storageDelete($COPA02ContentPages, 'path_image_icon');
            storageDelete($COPA02ContentPages, 'path_image_desktop');
            storageDelete($COPA02ContentPages, 'path_image_mobile');
        }


        if($deleted = COPA02ContentPages::whereIn('id', $request->deleteAll)->delete()){
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
            COPA02ContentPages::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('ContentPages', 'COPA02');

        return view('Client.pages.ContentPages.COPA02.page',[
            'sections' => $sections
        ]);
    }

}
