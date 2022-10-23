<?php

namespace App\Http\Controllers\Portfolios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portfolios\PORT01PortfoliosSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PORT01SectionController extends Controller
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

        $data['active'] = $request->active?1:0;

        $path_image = $helper->optimizeImage($request, 'path_image', $path, 800, 90);
        if($path_image) $data['path_image'] = $path_image;

        if(PORT01PortfoliosSection::create($data)){
            Session::flash('success', 'Informações cadastrada com sucesso');
        }else{
            Session::flash('success', 'Erro ao cadastradar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT01PortfoliosSection  $PORT01PortfoliosSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT01PortfoliosSection $PORT01PortfoliosSection)
    {
        $data = $request->all();
        $path = 'uploads/Portfolios/PORT01/images/';
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image = $helper->optimizeImage($request, 'path_image', $path, 800, 90);
        if($path_image){
            storageDelete($PORT01PortfoliosSection, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($PORT01PortfoliosSection, 'path_image');
            $data['path_image'] = null;
        }

        if($PORT01PortfoliosSection->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Session::flash('success', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }
}
