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

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $data['active'] = $request->active?1:0;

        if($section = COPA01ContentPagesSection::create($data)){
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
     * @param  \App\Models\ContentPages\COPA01ContentPagesSection  $COPA01ContentPagesSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COPA01ContentPagesSection $COPA01ContentPagesSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon){
            storageDelete($COPA01ContentPagesSection, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($COPA01ContentPagesSection, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $data['active'] = $request->active?1:0;

        if($COPA01ContentPagesSection->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
            Session::flash('reopenModal', 'modal-section-update-'.$COPA01ContentPagesSection->id);
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentPages\COPA01ContentPagesSection  $COPA01ContentPagesSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(COPA01ContentPagesSection $COPA01ContentPagesSection)
    {
        storageDelete($COPA01ContentPagesSection, 'path_image_icon');

        if($COPA01ContentPagesSection->delete()){
            Session::flash('success', 'Informações deletado com sucessso');
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
        $COPA01ContentPagesSections = COPA01ContentPagesSection::whereIn('id', $request->deleteAll)->get();
        foreach($COPA01ContentPagesSections as $COPA01ContentPagesSection){
            storageDelete($COPA01ContentPagesSection, 'path_image_icon');
        }

        if($deleted = COPA01ContentPagesSection::whereIn('id', $request->deleteAll)->delete()){
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
            COPA01ContentPagesSection::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
