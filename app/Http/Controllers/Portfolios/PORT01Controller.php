<?php

namespace App\Http\Controllers\Portfolios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portfolios\PORT01Portfolios;
use App\Models\Portfolios\PORT01PortfoliosCategory;
use App\Models\Portfolios\PORT01PortfoliosSection;
use App\Models\Portfolios\PORT01PortfoliosSubategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PORT01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = PORT01Portfolios::sorting()->paginate(32);
        $categories = PORT01PortfoliosCategory::active()->sorting()->get();
        $subcategories = PORT01PortfoliosSubategory::active()->sorting()->get();
        $section = PORT01PortfoliosSection::first();

        return view('Admin.cruds.Portfolios.PORT01.index',[
            'portfolios' => $portfolios,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'section' => $section,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PORT01PortfoliosCategory::active()->sorting()->pluck('title','id');
        $subcategories = PORT01PortfoliosSubategory::active()->sorting()->pluck('title','id');
        return view('Admin.cruds.Portfolios.PORT01.create',[
            'categories' => $categories,
            'subcategories' => $subcategories,
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

        /*
        Use the code below to upload image, if not, delete code

        $path = 'uploads/Module/Code/images/';
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $path, 200, 80);

        if($path_image) $data['path_image'] = $path_image;

        Use the code below to upload archive, if not, delete code

        $path = 'uploads/Module/Code/archives/';
        $helper = new HelperArchive();

        $path_archive = $helper->uploadArchive($request, 'path_archive', $path);

        if($path_archive) $data['path_archive'] = $path_archive;

        */

        if(PORT01Portfolios::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.code.index');
        }else{
            //Storage::delete($path_image);
            //Storage::delete($path_archive);
            Session::flash('success', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portfolios\PORT01Portfolios  $PORT01Portfolios
     * @return \Illuminate\Http\Response
     */
    public function edit(PORT01Portfolios $PORT01Portfolios)
    {
        $categories = PORT01PortfoliosCategory::active()->sorting()->pluck('title','id');
        $subcategories = PORT01PortfoliosSubategory::active()->sorting()->pluck('title','id');
        return view('Admin.cruds.Portfolios.PORT01.edit',[
            'portifolio' => $PORT01Portfolios,
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT01Portfolios  $PORT01Portfolios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT01Portfolios $PORT01Portfolios)
    {
        $data = $request->all();

        /*
        Use the code below to upload image, if not, delete code

        $path = 'uploads/Module/Code/images/';
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $path, 200, 80);
        if($path_image){
            Storage::delete($PORT01Portfolios->path_image);
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            Storage::delete($PORT01Portfolios->path_image);
            $data['path_image'] = null;
        }
        */

        /*
        Use the code below to upload archive, if not, delete code

        $path = 'uploads/Module/Code/archives/';
        $helper = new HelperArchive();

        $path_archive = $helper->uploadArchive($request, 'path_archive', $path);

        if($path_archive){
            Storage::delete($PORT01Portfolios->path_archive);
            $data['path_archive'] = $path_archive;
        }

        if($request->delete_path_archive && !$path_archive){
            Storage::delete($PORT01Portfolios->path_archive);
            $data['path_archive'] = null;
        }

        */

        if($PORT01Portfolios->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.code.index');
        }else{
            //Storage::delete($path_image);
            //Storage::delete($path_archive);
            Session::flash('success', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT01Portfolios  $PORT01Portfolios
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT01Portfolios $PORT01Portfolios)
    {
        //Storage::delete($PORT01Portfolios->path_image);
        //Storage::delete($PORT01Portfolios->path_archive);

        if($PORT01Portfolios->delete()){
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
        /* Use the code below to upload image or archive, if not, delete code

        $PORT01Portfolioss = PORT01Portfolios::whereIn('id', $request->deleteAll)->get();
        foreach($PORT01Portfolioss as $PORT01Portfolios){
            Storage::delete($PORT01Portfolios->path_image);
            Storage::delete($PORT01Portfolios->path_archive);
        }
        */

        if($deleted = PORT01Portfolios::whereIn('id', $request->deleteAll)->delete()){
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
            PORT01Portfolios::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Portfolios\PORT01Portfolios  $PORT01Portfolios
     * @return \Illuminate\Http\Response
     */
    public function show(PORT01Portfolios $PORT01Portfolios)
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
