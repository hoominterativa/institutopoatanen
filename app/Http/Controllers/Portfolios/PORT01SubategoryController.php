<?php

namespace App\Http\Controllers\Portfolios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portfolios\PORT01PortfoliosSubategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PORT01SubategoryController extends Controller
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

        $data['slug'] = $request->title;
        $data['featured'] = $request->featured?1:0;
        $data['active'] = $request->active?1:0;

        if(PORT01PortfoliosSubategory::create($data)){
            Session::flash('reopenModal', 'modal-subcategory-create');
            Session::flash('success', 'Subcategoria cadastrada com sucesso');
        }else{
            Session::flash('reopenModal', 'modal-subcategory-create');
            Session::flash('success', 'Erro ao cadastradar o subcategoria');
        }
        return redirect()->back();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT01PortfoliosSubategory  $PORT01PortfoliosSubategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT01PortfoliosSubategory $PORT01PortfoliosSubategory)
    {
        $data = $request->all();

        $data['slug'] = $request->title;
        $data['featured'] = $request->featured?1:0;
        $data['active'] = $request->active?1:0;

        if($PORT01PortfoliosSubategory->fill($data)->save()){
            Session::flash('reopenModal', 'modal-subcategory-create');
            Session::flash('success', 'Subcategoria atualizada com sucesso');
        }else{
            Session::flash('reopenModal', 'modal-subcategory-create');
            Session::flash('success', 'Erro ao atualizar subcategoria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT01PortfoliosSubategory  $PORT01PortfoliosSubategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT01PortfoliosSubategory $PORT01PortfoliosSubategory)
    {
        if($PORT01PortfoliosSubategory->delete()){
            Session::flash('reopenModal', 'modal-subcategory-create');
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
        if($deleted = PORT01PortfoliosSubategory::whereIn('id', $request->deleteAll)->delete()){
            Session::flash('reopenModal', 'modal-subcategory-create');
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
            PORT01PortfoliosSubategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Portfolios\PORT01PortfoliosSubategory  $PORT01PortfoliosSubategory
     * @return \Illuminate\Http\Response
     */
    public function show(PORT01PortfoliosSubategory $PORT01PortfoliosSubategory)
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
