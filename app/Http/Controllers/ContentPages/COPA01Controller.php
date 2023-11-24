<?php

namespace App\Http\Controllers\ContentPages;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\ContentPages\COPA01ContentPages;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA01ContentPagesSection;
use App\Models\ContentPages\COPA01ContentPagesSectionArchive;

class COPA01Controller extends Controller
{
    protected $path = 'uploads/ContentPages/COPA01/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contentPages = COPA01ContentPages::sorting()->get();
        $section = COPA01ContentPagesSection::first();
        return view('Admin.cruds.ContentPages.COPA01.index',[
            'contentPages' => $contentPages,
            'section' => $section,
            'cropSetting' => getCropImage('ContentPages', 'COPA01')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA01.create', [
            'cropSetting' => getCropImage('ContentPages', 'COPA01')
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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if($path_image) $data['path_image'] = $path_image;

        $data['active'] = $request->active ? 1 : 0;

        if($contentPage = COPA01ContentPages::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
            return redirect()->route('admin.copa01.edit', ['COPA01ContentPages' => $contentPage]);
        }else{
            Storage::delete($path_image);
            Session::flash('success', 'Erro ao cadastradar informações');
            return redirect()->back();
        }
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brands\COPA01ContentPages  $COPA01ContentPages
     * @return \Illuminate\Http\Response
     */
    public function edit(COPA01ContentPages $COPA01ContentPages)
    {
        $archives = COPA01ContentPagesSectionArchive::where('contentPage_id', $COPA01ContentPages->id)->sorting()->get();
        return view('Admin.cruds.ContentPages.COPA01.edit', [
            'contentPage' => $COPA01ContentPages,
            'archives' => $archives,
            'cropSetting' => getCropImage('ContentPages', 'COPA01')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentPages\COPA01ContentPages  $COPA01ContentPages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COPA01ContentPages $COPA01ContentPages)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if($path_image){
            storageDelete($COPA01ContentPages, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($COPA01ContentPages, 'path_image');
            $data['path_image'] = null;
        }

        $data['active'] = $request->active ? 1 : 0;

        if($COPA01ContentPages->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentPages\COPA01ContentPages  $COPA01ContentPages
     * @return \Illuminate\Http\Response
     */
    public function destroy(COPA01ContentPages $COPA01ContentPages)
    {
        $archives = COPA01ContentPagesSectionArchive::where('contentPage_id', $COPA01ContentPages->id)->get();
        foreach($archives as $archive){
            foreach($archives as $archive){
                storageDelete($archive, 'path_archive');
                $archive->delete();
            }
        }

        storageDelete($COPA01ContentPages, 'path_image');

        if($COPA01ContentPages->delete()){
            Session::flash('success', 'Informações deletadas com sucessso');
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
        $COPA01ContentPagess = COPA01ContentPages::whereIn('id', $request->deleteAll)->get();
        foreach($COPA01ContentPagess as $COPA01ContentPages){
            $archives = COPA01ContentPagesSectionArchive::where('contentPage_id', $COPA01ContentPages->id)->get();
            foreach($archives as $archive){
                foreach($archives as $archive){
                    storageDelete($archive, 'path_archive');
                    $archive->delete();
                }
            }

            storageDelete($COPA01ContentPages, 'path_image');
        }

        if($deleted = COPA01ContentPages::whereIn('id', $request->deleteAll)->delete()){
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
            COPA01ContentPages::where('id', $id)->update(['sorting' => $sorting]);
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('ContentPages', 'COPA01');

        $contentPages = COPA01ContentPages::with(['archives' => function ($query) {$query->where(['active' => 1]);}])->first();

        return view('Client.pages.ContentPages.COPA01.page',[
            'sections' => $sections,
            'contentPages' => $contentPages
        ]);
    }
}
