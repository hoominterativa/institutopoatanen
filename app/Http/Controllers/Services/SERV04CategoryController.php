<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV04ServicesCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV04CategoryController extends Controller
{
    protected $path = 'uploads/Services/SERV04/images/';

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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);

        if($path_image) $data['path_image'] = $path_image;

        if(SERV04ServicesCategory::create($data)){
            Session::flash('success', 'Categoria cadastrada com sucesso');
            return redirect()->route('admin.serv04.index');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar a categoria');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV04ServicesCategory  $SERV04ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV04ServicesCategory $SERV04ServicesCategory)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV04ServicesCategory, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV04ServicesCategory, 'path_image');
            $data['path_image'] = null;
        }

        if($SERV04ServicesCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
            return redirect()->route('admin.serv04.index');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar a categoria');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV04ServicesCategory  $SERV04ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV04ServicesCategory $SERV04ServicesCategory)
    {
        storageDelete($SERV04ServicesCategory, 'path_image');

        if($SERV04ServicesCategory->delete()){
            Session::flash('success', 'Categoria deletada com sucessso');
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

        $SERV04ServicesCategorys = SERV04ServicesCategory::whereIn('id', $request->deleteAll)->get();
        foreach($SERV04ServicesCategorys as $SERV04ServicesCategory){
            storageDelete($SERV04ServicesCategory, 'path_image');
        }
        
        if($deleted = SERV04ServicesCategory::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Categorias deletadas com sucessso']);
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
            SERV04ServicesCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
