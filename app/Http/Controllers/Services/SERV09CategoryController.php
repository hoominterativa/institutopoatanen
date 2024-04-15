<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV09Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV09ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;

class SERV09CategoryController extends Controller
{
    protected $path = 'uploads/Services/SERV09/images/';

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
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($request->title);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(SERV09ServicesCategory::create($data)){
            Session::flash('success', 'Categoria cadastrada com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar a categoria');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV09ServicesCategory  $SERV09ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV09ServicesCategory $SERV09ServicesCategory)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($request->title);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV09ServicesCategory, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV09ServicesCategory, 'path_image');
            $data['path_image'] = null;
        }

        if($SERV09ServicesCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar a categoria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV09ServicesCategory  $SERV09ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV09ServicesCategory $SERV09ServicesCategory)
    {

        storageDelete($SERV09ServicesCategory, 'path_image');

        if($SERV09ServicesCategory->delete()){
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
        $SERV09ServicesCategories = SERV09ServicesCategory::whereIn('id', $request->deleteAll)->get();
        foreach($SERV09ServicesCategories as $SERV09ServicesCategory){
            storageDelete($SERV09ServicesCategory, 'path_image');
        }

        if($deleted = SERV09ServicesCategory::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' categorias deletadas com sucesso']);
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
            SERV09ServicesCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
