<?php

namespace App\Http\Controllers\Compliances;

use App\Models\Compliances\COMP01CompliancesArchive;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COMP01ArchiveController extends Controller
{
    protected $path = 'uploads/Compliances/COMP01/archives/';

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

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->path);
        if($path_archive) $data['path_archive'] = $path_archive;

        if(COMP01CompliancesArchive::create($data)){
            Session::flash('success', 'Arquivo cadastrado com sucesso');
        }else{
            Storage::delete($path_archive);
            Session::flash('error', 'Erro ao cadastradar arquivo');
        }
        Session::flash('reopenModal', ['modal-archive-create-'.$request->section_id, 'modal-section-update-'.$request->section_id]);
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compliances\COMP01CompliancesArchive  $COMP01CompliancesArchive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COMP01CompliancesArchive $COMP01CompliancesArchive)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->path);
        if($path_archive){
            storageDelete($COMP01CompliancesArchive, 'path_archive');
            $data['path_archive'] = $path_archive;
        }

        if($request->delete_path_archive && !$path_archive){
            storageDelete($COMP01CompliancesArchive, 'path_archive');
            $data['path_archive'] = null;
        }

        if($COMP01CompliancesArchive->fill($data)->save()){
            Session::flash('success', 'Arquivo atualizado com sucesso');
        }else{
            Storage::delete($path_archive);
            Session::flash('error', 'Erro ao atualizar arquivo');
        }
        Session::flash('reopenModal', ['modal-archive-create', 'modal-section-update-'.$request->section_id]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compliances\COMP01CompliancesArchive  $COMP01CompliancesArchive
     * @return \Illuminate\Http\Response
     */
    public function destroy(COMP01CompliancesArchive $COMP01CompliancesArchive)
    {
        storageDelete($COMP01CompliancesArchive, 'path_archive');
        Session::flash('reopenModal', ['modal-archive-create-'.$COMP01CompliancesArchive->section_id, 'modal-section-update-'.$COMP01CompliancesArchive->section_id]);
        if($COMP01CompliancesArchive->delete()){
            Session::flash('success', 'Arquivo deletado com sucessso');
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
        $COMP01CompliancesArchives = COMP01CompliancesArchive::whereIn('id', $request->deleteAll)->get();
        foreach($COMP01CompliancesArchives as $COMP01CompliancesArchive){
            storageDelete($COMP01CompliancesArchive, 'path_archive');
        }

        Session::flash('reopenModal', ['modal-archive-create-'.$COMP01CompliancesArchives[0]->section_id, 'modal-section-update-'.$COMP01CompliancesArchives[0]->section_id]);

       if($deleted = COMP01CompliancesArchive::whereIn('id', $request->deleteAll)->delete()){
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
            COMP01CompliancesArchive::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
