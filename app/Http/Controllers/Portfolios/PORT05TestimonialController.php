<?php

namespace App\Http\Controllers\Portfolios;

use App\Models\Portfolios\PORT05PortfoliosTestimonial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class PORT05TestimonialController extends Controller
{
    protected $path = 'uploads/Portfolios/PORT05/images/';

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

        if(PORT05PortfoliosTestimonial::create($data)){
            Session::flash('success', 'Depoimento cadastrado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o depoimento');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT05PortfoliosTestimonial  $PORT05PortfoliosTestimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT05PortfoliosTestimonial $PORT05PortfoliosTestimonial)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($PORT05PortfoliosTestimonial, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($PORT05PortfoliosTestimonial, 'path_image');
            $data['path_image'] = null;
        }

        if($PORT05PortfoliosTestimonial->fill($data)->save()){
            Session::flash('success', 'Depoimento atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar o depoimento');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT05PortfoliosTestimonial  $PORT05PortfoliosTestimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT05PortfoliosTestimonial $PORT05PortfoliosTestimonial)
    {
        storageDelete($PORT05PortfoliosTestimonial, 'path_image');

        if($PORT05PortfoliosTestimonial->delete()){
            Session::flash('success', 'Depoimento deletado com sucessso');
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

        $PORT05PortfoliosTestimonials = PORT05PortfoliosTestimonial::whereIn('id', $request->deleteAll)->get();
        foreach($PORT05PortfoliosTestimonials as $PORT05PortfoliosTestimonial){
            storageDelete($PORT05PortfoliosTestimonial, 'path_image');
        }

        if($deleted = PORT05PortfoliosTestimonial::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' depoimentos deletados com sucessso']);
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
            PORT05PortfoliosTestimonial::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
