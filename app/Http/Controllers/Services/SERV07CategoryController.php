<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV07ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;

class SERV07CategoryController extends Controller
{
    protected $path = 'uploads/Services/SERV07/images/';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Admin.cruds.Services.SERV07.Category.create",[
            'cropSetting' => getCropImage('Services', 'SERV07')
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
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($request->title . ($request->subtitle ? '-' . $request->subtitle : ''));

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if($category = SERV07ServicesCategory::create($data)){
            Session::flash('success', 'Categoria cadastrada com sucesso');
            return redirect()->route('admin.serv07.category.edit', ['SERV07ServicesCategory' => $category->id]);
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar a categoria');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV07ServicesCategory  $SERV07ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV07ServicesCategory $SERV07ServicesCategory)
    {
        return view("Admin.cruds.Services.SERV07.Category.edit",[
            'category' => $SERV07ServicesCategory,
            'cropSetting' => getCropImage('Services', 'SERV07')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV07ServicesCategory  $SERV07ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV07ServicesCategory $SERV07ServicesCategory)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($request->title . ($request->subtitle ? '-' . $request->subtitle : ''));

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV07ServicesCategory, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV07ServicesCategory, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($SERV07ServicesCategory, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($SERV07ServicesCategory, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($SERV07ServicesCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar a categoria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV07ServicesCategory  $SERV07ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV07ServicesCategory $SERV07ServicesCategory)
    {
        storageDelete($SERV07ServicesCategory, 'path_image');
        storageDelete($SERV07ServicesCategory, 'path_image_icon');

        if($SERV07ServicesCategory->delete()){
            Session::flash('success', 'Categoria deletada com sucessso');
        }
        return redirect()->back();
    }

    /**
     * Remove the selected resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request)
    {

        $SERV07ServicesCategorys = SERV07ServicesCategory::whereIn('id', $request->deleteAll)->get();
        foreach($SERV07ServicesCategorys as $SERV07ServicesCategory){
            storageDelete($SERV07ServicesCategory, 'path_image_icon');
            storageDelete($SERV07ServicesCategory, 'path_image');
        }

        if($deleted = SERV07ServicesCategory::whereIn('id', $request->deleteAll)->delete()){
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
            SERV07ServicesCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
