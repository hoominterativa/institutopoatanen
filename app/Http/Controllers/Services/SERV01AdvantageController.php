<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Services\SERV01ServicesAdvantage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SERV01AdvantageController extends Controller
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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, 450, 80);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, 200, 100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(SERV01ServicesAdvantage::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao cadastradar o item');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV01ServicesAdvantage  $SERV01ServicesAdvantage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV01ServicesAdvantage $SERV01ServicesAdvantage)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, 450, 100);
        if($path_image){
            storageDelete($SERV01ServicesAdvantage, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV01ServicesAdvantage, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, 200, 100);
        if($path_image_icon){
            storageDelete($SERV01ServicesAdvantage, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($SERV01ServicesAdvantage, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($SERV01ServicesAdvantage->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao atualizar item');
        }
        Session::flash('reopenModal', 'modal-advantage-update');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV01ServicesAdvantage  $SERV01ServicesAdvantage
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV01ServicesAdvantage $SERV01ServicesAdvantage)
    {
        storageDelete($SERV01ServicesAdvantage, 'path_image');
        storageDelete($SERV01ServicesAdvantage, 'path_image_icon');

        if($SERV01ServicesAdvantage->delete()){
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
        $SERV01ServicesAdvantages = SERV01ServicesAdvantage::whereIn('id', $request->deleteAll)->get();
        foreach($SERV01ServicesAdvantages as $SERV01ServicesAdvantage){
            storageDelete($SERV01ServicesAdvantage, 'path_image');
            storageDelete($SERV01ServicesAdvantage, 'path_image_icon');
        }

        if($deleted = SERV01ServicesAdvantage::whereIn('id', $request->deleteAll)->delete()){
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
            SERV01ServicesAdvantage::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
