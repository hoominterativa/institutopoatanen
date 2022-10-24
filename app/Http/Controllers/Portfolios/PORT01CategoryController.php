<?php

namespace App\Http\Controllers\Portfolios;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portfolios\PORT01PortfoliosCategory;

class PORT01CategoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $path = 'uploads/Portfolios/PORT01/images/';
        $helper = new HelperArchive();

        try {
            $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $path, 200, 100);
            if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

            $data['slug'] = Str::slug($request->title);
            $data['view_menu'] = $request->view_menu?1:0;
            $data['featured'] = $request->featured?1:0;
            $data['active'] = $request->active?1:0;

            if(PORT01PortfoliosCategory::create($data)){
                Session::flash('success', 'Categoria cadastrada com sucesso');
            }else{
                Storage::delete($path_image_icon);
                Session::flash('error', 'Erro ao cadastradar categoria');
            }

            Session::flash('reopenModal', 'modal-category-create');
            return redirect()->back();
        } catch (Exception $e) {
            Session::flash('reopenModal', 'modal-category-create');
            Session::flash('error', 'Erro: '.$e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT01PortfoliosCategory  $PORT01PortfoliosCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT01PortfoliosCategory $PORT01PortfoliosCategory)
    {
        $data = $request->all();
        $path = 'uploads/Portfolios/PORT01/images/';
        $helper = new HelperArchive();

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $path, 200, 100);
        if($path_image_icon){
            storageDelete($PORT01PortfoliosCategory, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($PORT01PortfoliosCategory, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $data['slug'] = Str::slug($request->title);
        $data['view_menu'] = $request->view_menu?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['active'] = $request->active?1:0;

        if($PORT01PortfoliosCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao atualizar categoria');
        }

        Session::flash('reopenModal', 'modal-category-create');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT01PortfoliosCategory  $PORT01PortfoliosCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT01PortfoliosCategory $PORT01PortfoliosCategory)
    {
        storageDelete($PORT01PortfoliosCategory, 'path_image_icon');
        if($PORT01PortfoliosCategory->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            Session::flash('reopenModal', 'modal-category-create');
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
        $PORT01PortfoliosCategorys = PORT01PortfoliosCategory::whereIn('id', $request->deleteAll)->get();
        foreach($PORT01PortfoliosCategorys as $PORT01PortfoliosCategory){
            storageDelete($PORT01PortfoliosCategory, 'path_image_icon');
        }

        if($deleted = PORT01PortfoliosCategory::whereIn('id', $request->deleteAll)->delete()){
            Session::flash('reopenModal', 'modal-category-create');
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
            PORT01PortfoliosCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Portfolios\PORT01PortfoliosCategory  $PORT01PortfoliosCategory
     * @return \Illuminate\Http\Response
     */
    public function show(PORT01PortfoliosCategory $PORT01PortfoliosCategory)
    {
        //
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Module', 'Model');

        return view('Client.pages.Module.Model.page',[
            'sections' => $sections
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        return view('');
    }
}
