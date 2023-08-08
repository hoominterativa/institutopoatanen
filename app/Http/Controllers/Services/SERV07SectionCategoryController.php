<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV07ServicesSectionCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV07SectionCategoryController extends Controller
{
    protected $path = 'uploads/Services/SERV07/images/';

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
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(SERV07ServicesSectionCategory::create($data)){
            Session::flash('success', 'Seção cadastrada com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar a seção');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV07ServicesSectionCategory  $SERV07ServicesSectionCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV07ServicesSectionCategory $SERV07ServicesSectionCategory)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['link_button'] = isset($data['link_button']) ?getUri($data['link_button']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV07ServicesSectionCategory, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV07ServicesSectionCategory, 'path_image');
            $data['path_image'] = null;
        }

        if($SERV07ServicesSectionCategory->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV07ServicesSectionCategory  $SERV07ServicesSectionCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV07ServicesSectionCategory $SERV07ServicesSectionCategory)
    {
        storageDelete($SERV07ServicesSectionCategory, 'path_image');

        if($SERV07ServicesSectionCategory->delete()){
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

        $SERV07ServicesSectionCategorys = SERV07ServicesSectionCategory::whereIn('id', $request->deleteAll)->get();
        foreach($SERV07ServicesSectionCategorys as $SERV07ServicesSectionCategory){
            storageDelete($SERV07ServicesSectionCategory, 'path_image');
        }

        if($deleted = SERV07ServicesSectionCategory::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Seções deletados com sucessso']);
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
            SERV07ServicesSectionCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
