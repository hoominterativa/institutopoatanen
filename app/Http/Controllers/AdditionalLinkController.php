<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdditionalLink;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\CallToActionTitle;

class AdditionalLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $additionalLinks = AdditionalLink::get();
        $callToActionTitle = CallToActionTitle::first();

        $linksHeader = AdditionalLink::where('position', 'header')->orWhere('position', 'both')->count();
        $linksFooter = AdditionalLink::where('position', 'footer')->orWhere('position', 'both')->count();

        return view('Admin.cruds.AdditionalLink.index',[
            'additionalLinks' => $additionalLinks,
            'callToActionTitle' => $callToActionTitle,
            'linksHeader' => $linksHeader,
            'linksFooter' => $linksFooter,
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
        $data['active'] = $request->active?1:0;

        $data['link'] = getUri($data['link']);

        if(AdditionalLink::create($data)){
            Session::flash('success', 'Link cadastrado com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar link');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdditionalLink  $AdditionalLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdditionalLink $AdditionalLink)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;

        $data['link'] = getUri($data['link']);

        if($AdditionalLink->fill($data)->save()){
            Session::flash('success', 'link atualizado com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar link');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdditionalLink  $AdditionalLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdditionalLink $AdditionalLink)
    {
        if($AdditionalLink->delete()){
            Session::flash('success', 'link deletado com sucessso');
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
        if($deleted = AdditionalLink::whereIn('id', $request->deleteAll)->delete()){
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
            AdditionalLink::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
