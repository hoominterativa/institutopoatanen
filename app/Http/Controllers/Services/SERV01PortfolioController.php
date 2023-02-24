<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Services\SERV01ServicesPortfolio;
use App\Models\Services\SERV01ServicesPortfolioGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SERV01PortfolioController extends Controller
{
    protected $path = 'uploads/Services/SERV01/images/';

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

        if($portfolio = SERV01ServicesPortfolio::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('success', 'Erro ao cadastradar o item');
        }
        Session::flash('reopenModal', 'modal-portfolio-update-'.$portfolio->id);
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV01ServicesPortfolio  $SERV01ServicesPortfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV01ServicesPortfolio $SERV01ServicesPortfolio)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV01ServicesPortfolio, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV01ServicesPortfolio, 'path_image');
            $data['path_image'] = null;
        }

        if($SERV01ServicesPortfolio->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('success', 'Erro ao atualizar item');
        }
        Session::flash('reopenModal', 'modal-portfolio-update-'.$SERV01ServicesPortfolio->id);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV01ServicesPortfolio  $SERV01ServicesPortfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV01ServicesPortfolio $SERV01ServicesPortfolio)
    {
        $galleries = SERV01ServicesPortfolioGallery::where('portfolio_id', $SERV01ServicesPortfolio->id)->get();
        foreach ($galleries as $gallery) {
            storageDelete($gallery, 'path_image');
            $gallery->delete();
        }

        storageDelete($SERV01ServicesPortfolio, 'path_image');

        if($SERV01ServicesPortfolio->delete()){
            Session::flash('success', 'Item deletado com sucessso');
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
        $SERV01ServicesPortfolios = SERV01ServicesPortfolio::whereIn('id', $request->deleteAll)->get();
        foreach($SERV01ServicesPortfolios as $SERV01ServicesPortfolio){

            $galleries = SERV01ServicesPortfolioGallery::where('portfolio_id', $SERV01ServicesPortfolio->id)->get();
            foreach ($galleries as $gallery) {
                storageDelete($gallery, 'path_image');
                $gallery->delete();
            }

            storageDelete($SERV01ServicesPortfolio, 'path_image');
        }

        if($deleted = SERV01ServicesPortfolio::whereIn('id', $request->deleteAll)->delete()){
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
            SERV01ServicesPortfolio::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
