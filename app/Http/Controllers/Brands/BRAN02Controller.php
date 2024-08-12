<?php

namespace App\Http\Controllers\Brands;

use App\Models\Brands\BRAN02Brands;
use App\Models\Brands\BRAN02BrandsProducts;
use App\Models\Brands\BRAN02BrandsSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class BRAN02Controller extends Controller
{
    protected $path = 'uploads/brands/BRAN02/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bran02 = BRAN02Brands::first();
        $bran02section = BRAN02BrandsSection::sorting()->get();
        $bran02products = BRAN02BrandsProducts::sorting()->get();
        //dd($bran02products, $bran02section, $bran02);
        return view('Admin.cruds.Brands.BRAN02.index', [
            'bran02' => $bran02,
            'bran02section' => $bran02section,
            'bran02products' => $bran02products,
            'cropSetting' => getCropImage('Brands', 'BRAN02')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Brands.BRAN02.create', [
            'cropSetting' => getCropImage('Brands', 'BRAN02')
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


        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);

        if ($path_image) $data['path_image'] = $path_image;



        if (BRAN02Brands::create($data)) {
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.bran02.index');
        } else {
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brands\BRAN02Brands  $BRAN02Brands
     * @return \Illuminate\Http\Response
     */
    public function edit(BRAN02Brands $BRAN02Brands)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brands\BRAN02Brands  $BRAN02Brands
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BRAN02Brands $BRAN02Brands)
    {
        $data = $request->all();

        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) {
            storageDelete($BRAN02Brands, 'path_image');
            $data['path_image'] = $path_image;
        }
        if ($request->delete_path_image && !$path_image) {
            storageDelete($BRAN02Brands, 'path_image');
            $data['path_image'] = null;
        }




        if ($BRAN02Brands->fill($data)->save()) {
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.bran02.index');
        } else {
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brands\BRAN02Brands  $BRAN02Brands
     * @return \Illuminate\Http\Response
     */
    public function destroy(BRAN02Brands $BRAN02Brands)
    {
        storageDelete($BRAN02Brands, 'path_image');


        if ($BRAN02Brands->delete()) {
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


        $BRAN02Brandss = BRAN02Brands::whereIn('id', $request->deleteAll)->get();
        foreach ($BRAN02Brandss as $BRAN02Brands) {
            storageDelete($BRAN02Brands, 'path_image');
        }


        if ($deleted = BRAN02Brands::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' itens deletados com sucessso']);
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
        foreach ($request->arrId as $sorting => $id) {
            BRAN02Brands::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Brands\BRAN02Brands  $BRAN02Brands
     * @return \Illuminate\Http\Response
     *
     * */
    public function show($BRAN02Brands)
    {
        //dd($BRAN02Brands);
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Brands', 'BRAN02', 'show');
        $bran02 = BRAN02Brands::first();
        $bran02products = BRAN02BrandsProducts::where('category_id', $BRAN02Brands)->active()->sorting()->get();
        $bran02section1 = BRAN02BrandsSection::active()->highlighted()->sorting()->get();
        $bran02section2 = BRAN02BrandsSection::active()->NoHighlighted()->sorting()->get();

        return view('Client.pages.Brands.BRAN02.page', [
            'sections' => $sections,
            'content' => $bran02,
            'bran02section1' => $bran02section1,
            'bran02section2' => $bran02section2,
            'bran02products' => $bran02products
        ]);
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Brands', 'BRAN02', 'page');
        $bran02products = BRAN02BrandsProducts::active()->sorting()->get();
        $bran02section1 = BRAN02BrandsSection::active()->highlighted()->sorting()->get();
        $bran02section2 = BRAN02BrandsSection::active()->NoHighlighted()->sorting()->get();
        $content = BRAN02Brands::first();

        return view('Client.pages.Brands.BRAN02.page', [
            'sections' => $sections,
            'bran02products' => $bran02products,
            'bran02section1' => $bran02section1,
            'bran02section2' => $bran02section2,
            'content' => $content
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $content = BRAN02Brands::first();
        $bran02section1 = BRAN02BrandsSection::active()->highlighted()->sorting()->get();
        $bran02section2 = BRAN02BrandsSection::active()->NoHighlighted()->sorting()->get();
        $bran02products = BRAN02BrandsProducts::active()->highlighted()->sorting()->get();

        return view('Client.pages.Brands.BRAN02.section', compact('content', 'bran02section1', 'bran02section2', 'bran02products'));
    }
}