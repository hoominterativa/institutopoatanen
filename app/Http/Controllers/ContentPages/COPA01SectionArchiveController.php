<?php

namespace App\Http\Controllers\ContentPages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA01ContentPagesSectionArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class COPA01SectionArchiveController extends Controller
{
    protected $path = 'uploads/ContentPages/COPA01/archives/';

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

        $data['active'] = $request->active ? 1 : 0;

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->path);
        if($path_archive) $data['path_archive'] = $path_archive;

        if(COPA01ContentPagesSectionArchive::create($data)){
            Session::flash('success', 'Arquivo cadastrado com sucesso');
        }else{
            Storage::delete($path_archive);
            Session::flash('error', 'Erro ao cadastradar arquivo');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentPages\COPA01ContentPagesSectionArchive  $COPA01ContentPagesSectionArchive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COPA01ContentPagesSectionArchive $COPA01ContentPagesSectionArchive)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->path);
        if($path_archive){
            storageDelete($COPA01ContentPagesSectionArchive, 'path_archive');
            $data['path_archive'] = $path_archive;
        }

        if($request->delete_path_archive && !$path_archive){
            storageDelete($COPA01ContentPagesSectionArchive, 'path_archive');
            $data['path_archive'] = null;
        }

        if($COPA01ContentPagesSectionArchive->fill($data)->save()){
            Session::flash('success', 'Arquivo atualizado com sucesso');
        }else{
            Storage::delete($path_archive);
            Session::flash('error', 'Erro ao atualizar arquivo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentPages\COPA01ContentPagesSectionArchive  $COPA01ContentPagesSectionArchive
     * @return \Illuminate\Http\Response
     */
    public function destroy(COPA01ContentPagesSectionArchive $COPA01ContentPagesSectionArchive)
    {
        storageDelete($COPA01ContentPagesSectionArchive, 'path_archive');

        if($COPA01ContentPagesSectionArchive->delete()){
            Session::flash('success', 'Item deletado com sucessso');
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
        $COPA01ContentPagesSectionArchives = COPA01ContentPagesSectionArchive::whereIn('id', $request->deleteAll)->get();
        foreach($COPA01ContentPagesSectionArchives as $COPA01ContentPagesSectionArchive){
            storageDelete($COPA01ContentPagesSectionArchive, 'path_archive');
        }

        if($deleted = COPA01ContentPagesSectionArchive::whereIn('id', $request->deleteAll)->delete()){
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
            COPA01ContentPagesSectionArchive::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
