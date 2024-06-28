<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV12ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;

class SERV12CategoryController extends Controller
{
    protected $path = 'uploads/Services/SERV12/images/';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Services.SERV12.Categories.create',[
            'cropSetting' => getCropImage('Services', 'SERV12'),
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

        $data['active_banner'] = $request->active_banner ? 1 : 0;
        $data['active'] = $request->active ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;

        if ($request->title) $data['slug'] = Str::slug($request->title);

        //Categories
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        //Banner
        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner) $data['path_image_desktop_banner'] = $path_image_desktop_banner;

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner) $data['path_image_mobile_banner'] = $path_image_mobile_banner;

        if($category = SERV12ServicesCategory::create($data)){
            Session::flash('success', 'Categoria cadastrada com sucesso');
            return redirect()->route('admin.serv12.category.edit', ['SERV12ServicesCategory' => $category->id]);
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Session::flash('error', 'Erro ao cadastradar a categoria');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV12ServicesCategory  $SERV12ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV12ServicesCategory $SERV12ServicesCategory)
    {
        return view('Admin.cruds.Services.SERV12.Categories.edit',[
            'cropSetting' => getCropImage('Services', 'SERV12'),
            'category' => $SERV12ServicesCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV12ServicesCategory  $SERV12ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV12ServicesCategory $SERV12ServicesCategory)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active_banner'] = $request->active_banner ? 1 : 0;
        $data['active'] = $request->active ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;

        if ($request->title) $data['slug'] = Str::slug($request->title);

        //Categories
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV12ServicesCategory, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV12ServicesCategory, 'path_image');
            $data['path_image'] = null;
        }

        //Banner
        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner){
            storageDelete($SERV12ServicesCategory, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if($request->delete_path_image_desktop_banner && !$path_image_desktop_banner){
            storageDelete($SERV12ServicesCategory, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner){
            storageDelete($SERV12ServicesCategory, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if($request->delete_path_image_mobile_banner && !$path_image_mobile_banner){
            storageDelete($SERV12ServicesCategory, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }

        if($SERV12ServicesCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Session::flash('error', 'Erro ao atualizar a categoria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV12ServicesCategory  $SERV12ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV12ServicesCategory $SERV12ServicesCategory)
    {
        storageDelete($SERV12ServicesCategory, 'path_image');
        storageDelete($SERV12ServicesCategory, 'path_image_desktop_banner');
        storageDelete($SERV12ServicesCategory, 'path_image_mobile_banner');

        if($SERV12ServicesCategory->delete()){
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
        $SERV12ServicesCategories = SERV12ServicesCategory::whereIn('id', $request->deleteAll)->get();
        foreach($SERV12ServicesCategories as $SERV12ServicesCategory){
            storageDelete($SERV12ServicesCategory, 'path_image');
            storageDelete($SERV12ServicesCategory, 'path_image_desktop_banner');
            storageDelete($SERV12ServicesCategory, 'path_image_mobile_banner');
        }

        if($deleted = SERV12ServicesCategory::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' categorias deletadas com sucessso']);
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
            SERV12ServicesCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
