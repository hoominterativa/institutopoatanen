<?php

namespace App\Http\Controllers\Brands;


use App\Models\Brands\BRAN02Brands;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Brands\BRAN02BrandsSection;
use Illuminate\Support\Str;

class BRAN02SectionController extends Controller
{
    protected $path = 'uploads/Brands/BRAN02/images/';
/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Brands.BRAN02.categories.create', [
            'cropSetting' => getCropImage('Brands', 'BRAN01')
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

        $data['active'] = $request->active ? 1 : 0;
        $data['highlighted'] = $request->highlighted ? 1 : 0;
        
        $data['slug'] = Str::slug($request->category);
        //dd($data);
        if(BRAN02BrandsSection::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.bran02.index');
        }else{
            Session::flash('error', 'Erro ao cadastradar o categories');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brands\BRAN02Brands  $BRAN02Brands
     * @return \Illuminate\Http\Response
     */
    public function edit(BRAN02BrandsSection $BRAN02BrandsSection)
    {
       // @dd($BRAN02BrandsSection);
        return view('Admin.cruds.Brands.BRAN02.categories.edit', [
            'cropSetting' => getCropImage('Brands', 'BRAN01'),
            'BRAN02BrandsSection' => $BRAN02BrandsSection,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brands\BRAN02Brands  $BRAN02Brands
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BRAN02BrandsSection $BRAN02BrandsSection)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;
        $data['highlighted'] = $request->highlighted ? 1 : 0;
        $data['slug'] = Str::slug($request->category);

        //@dd($data, $BRAN02BrandsSection);
        if($BRAN02BrandsSection->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.bran02.index');
        }else{
            Session::flash('error', 'Erro ao atualizar categories');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brands\BRAN02Brands  $BRAN02Brands
     * @return \Illuminate\Http\Response
     */
    public function destroy(BRAN02BrandsSection $BRAN02BrandsSection)
    {
        storageDelete($BRAN02BrandsSection, 'path_image');


        if($BRAN02BrandsSection->delete()){
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


        $BRAN02Brandss = BRAN02BrandsSection::whereIn('id', $request->deleteAll)->get();
        foreach($BRAN02Brandss as $BRAN02Brands){
            storageDelete($BRAN02Brands, 'path_image');
        }
        

        if($deleted = BRAN02BrandsSection::whereIn('id', $request->deleteAll)->delete()){
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
            BRAN02BrandsSection::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}