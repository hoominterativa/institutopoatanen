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
use App\Models\ContentPages\COPA03ContentPagesSubCategoryTopic;

class COPA03SubCategoryTopicController extends Controller
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

        if(COPA03ContentPagesSubCategoryTopic::create($data)){
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
     * @param  \App\Models\ContentPages\COPA03ContentPagesSubCategoryTopic  $COPA03ContentPagesSubCategoryT
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COPA03ContentPagesSubCategoryTopic $COPA03ContentPagesSubCategoryT)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        if($request->title) $data['slug'] = Str::slug($request->title);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($COPA03ContentPagesSubCategoryT, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($COPA03ContentPagesSubCategoryT, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($COPA03ContentPagesSubCategoryT->fill($data)->save()){
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
     * @param  \App\Models\ContentPages\COPA03ContentPagesSubCategoryTopic  $COPA03ContentPagesSubCategoryT
     * @return \Illuminate\Http\Response
     */
    public function destroy(COPA03ContentPagesSubCategoryTopic $COPA03ContentPagesSubCategoryT)
    {
        storageDelete($COPA03ContentPagesSubCategoryT, 'path_image_icon');

        if($COPA03ContentPagesSubCategoryT->delete()){
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

        $COPA03ContentPagesSubCategoryTs = COPA03ContentPagesSubCategoryTopic::whereIn('id', $request->deleteAll)->get();
        foreach($COPA03ContentPagesSubCategoryTs as $COPA03ContentPagesSubCategoryT){
            storageDelete($COPA03ContentPagesSubCategoryT, 'path_image_icon');
        }

        if($deleted = COPA03ContentPagesSubCategoryTopic::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' subcategorias deletadas com sucessso']);
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
            COPA03ContentPagesSubCategoryTopic::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
