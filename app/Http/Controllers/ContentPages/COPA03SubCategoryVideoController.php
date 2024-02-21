<?php

namespace App\Http\Controllers\ContentPages;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA03ContentPagesSubCategoryVideo;

class COPA03SubCategoryVideoController extends Controller
{
    protected $path = 'uploads/ContentPages/COPA03/images/';

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

        if($request->title) $data['slug'] = Str::slug($request->title);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(COPA03ContentPagesSubCategoryVideo::create($data)){
            Session::flash('success', 'Subcategoria cadastrada com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar a subcategoria');
        }
            return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentPages\COPA03ContentPagesSubCategoryVideo  $COPA03ContentPagesSubCategoryV
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COPA03ContentPagesSubCategoryVideo $COPA03ContentPagesSubCategoryV)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        if($request->title) $data['slug'] = Str::slug($request->title);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($COPA03ContentPagesSubCategoryV, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($COPA03ContentPagesSubCategoryV, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($COPA03ContentPagesSubCategoryV->fill($data)->save()){
            Session::flash('success', 'Subcategoria atualizada com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar a subcategoria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentPages\COPA03ContentPagesSubCategoryVideo  $COPA03ContentPagesSubCategoryV
     * @return \Illuminate\Http\Response
     */
    public function destroy(COPA03ContentPagesSubCategoryVideo $COPA03ContentPagesSubCategoryV)
    {
        storageDelete($COPA03ContentPagesSubCategoryV, 'path_image_icon');

        if($COPA03ContentPagesSubCategoryV->delete()){
            Session::flash('success', 'Subcategoria deletada com sucessso');
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

        $COPA03ContentPagesSubCategoryVs = COPA03ContentPagesSubCategoryVideo::whereIn('id', $request->deleteAll)->get();
        foreach($COPA03ContentPagesSubCategoryVs as $COPA03ContentPagesSubCategoryV){
            storageDelete($COPA03ContentPagesSubCategoryV, 'path_image');
        }

        if($deleted = COPA03ContentPagesSubCategoryVideo::whereIn('id', $request->deleteAll)->delete()){
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
            COPA03ContentPagesSubCategoryVideo::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
