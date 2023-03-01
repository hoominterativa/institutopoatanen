<?php

namespace App\Http\Controllers\Compliances;

use App\Models\Compliances\COMP01CompliancesSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COMP01SectionController extends Controller
{
    protected $path = 'uploads/Compliances/COMP01/images/';

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

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $data['active'] = $request->active?1:0;

        if($section = COMP01CompliancesSection::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
            Session::flash('reopenModal', 'modal-section-update-'.$section->id);
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compliances\COMP01CompliancesSection  $COMP01CompliancesSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COMP01CompliancesSection $COMP01CompliancesSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon){
            storageDelete($COMP01CompliancesSection, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($COMP01CompliancesSection, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $data['active'] = $request->active?1:0;

        if($COMP01CompliancesSection->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
            Session::flash('reopenModal', 'modal-section-update-'.$COMP01CompliancesSection->id);
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compliances\COMP01CompliancesSection  $COMP01CompliancesSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(COMP01CompliancesSection $COMP01CompliancesSection)
    {
        foreach($COMP01CompliancesSection->archives as $archive){
            storageDelete($archive, 'path_archive');
            $archive->delete();
        }

        storageDelete($COMP01CompliancesSection, 'path_image_icon');

        if($COMP01CompliancesSection->delete()){
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

        $COMP01CompliancesSections = COMP01CompliancesSection::whereIn('id', $request->deleteAll)->get();
        foreach($COMP01CompliancesSections as $COMP01CompliancesSection){
            storageDelete($COMP01CompliancesSection, 'path_image_icon');
        }

        if($deleted = COMP01CompliancesSection::whereIn('id', $request->deleteAll)->delete()){
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
            COMP01CompliancesSection::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
