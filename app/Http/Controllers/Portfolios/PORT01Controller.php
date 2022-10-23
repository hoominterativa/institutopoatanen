<?php

namespace App\Http\Controllers\Portfolios;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Portfolios\PORT01Portfolios;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Portfolios\PORT01PortfoliosSection;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portfolios\PORT01PortfoliosCategory;
use App\Models\Portfolios\PORT01PortfoliosSubategory;

class PORT01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = PORT01Portfolios::with(['category','subcategory'])->sorting()->paginate(32);
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
        $path = 'uploads/Portfolios/PORT01/images/';
        $helper = new HelperArchive();

        $colorDelete = array_search(end($data['colors']), $data['colors']);
        unset($data['colors'][$colorDelete]);
        $data['colors'] = implode(',', $data['colors']);
        $data['slug'] = Str::slug($data['title']);

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $path, 400, 90);
        if($path_image_box) $data['path_image_box'] = $path_image_box;

        $path_image_left = $helper->optimizeImage($request, 'path_image_left', $path, 600, 90);
        if($path_image_left) $data['path_image_left'] = $path_image_left;

        $path_image_right = $helper->optimizeImage($request, 'path_image_right', $path, 600, 90);
        if($path_image_right) $data['path_image_right'] = $path_image_right;

        $path_image_testimonial = $helper->optimizeImage($request, 'path_image_testimonial', $path, 500, 90);
        if($path_image_testimonial) $data['path_image_testimonial'] = $path_image_testimonial;

        if(PORT01Portfolios::create($data)){
            Session::flash('success', 'Portifólio cadastrado com sucesso');
            return redirect()->route('admin.port01.index');
        }else{
            Storage::delete($path_image_box);
            Storage::delete($path_image_left);
            Storage::delete($path_image_right);
            Storage::delete($path_image_testimonial);
            Session::flash('success', 'Erro ao cadastradar portifólio');
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
            'portfolio' => $PORT01Portfolios,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'galleries' => $PORT01Portfolios->galleries,
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

        $path = 'uploads/Portfolio/PORT01/images/';
        $helper = new HelperArchive();

        $colorDelete = array_search(end($data['colors']), $data['colors']);
        unset($data['colors'][$colorDelete]);
        $data['colors'] = implode(',', $data['colors']);
        $data['slug'] = Str::slug($data['title']);


        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $path, 200, 80);
        if($path_image_box){
            storageDelete($PORT01Portfolios, 'path_image');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($PORT01Portfolios, 'path_image');
            $data['path_image_box'] = null;
        }

        $path_image_left = $helper->optimizeImage($request, 'path_image_left', $path, 200, 80);
        if($path_image_left){
            storageDelete($PORT01Portfolios, 'path_image');
            $data['path_image_left'] = $path_image_left;
        }
        if($request->delete_path_image_left && !$path_image_left){
            storageDelete($PORT01Portfolios, 'path_image');
            $data['path_image_left'] = null;
        }

        $path_image_right = $helper->optimizeImage($request, 'path_image_right', $path, 200, 80);
        if($path_image_right){
            storageDelete($PORT01Portfolios, 'path_image');
            $data['path_image_right'] = $path_image_right;
        }
        if($request->delete_path_image_right && !$path_image_right){
            storageDelete($PORT01Portfolios, 'path_image');
            $data['path_image_right'] = null;
        }

        $path_image_testimonial = $helper->optimizeImage($request, 'path_image_testimonial', $path, 200, 80);
        if($path_image_testimonial){
            storageDelete($PORT01Portfolios, 'path_image');
            $data['path_image_testimonial'] = $path_image_testimonial;
        }
        if($request->delete_path_image_testimonial && !$path_image_testimonial){
            storageDelete($PORT01Portfolios, 'path_image');
            $data['path_image_testimonial'] = null;
        }

        if($PORT01Portfolios->fill($data)->save()){
            Session::flash('success', 'Portifólio atualizado com sucesso');
        }else{
            Storage::delete($path_image_box);
            Storage::delete($path_image_left);
            Storage::delete($path_image_right);
            Storage::delete($path_image_testimonial);
            Session::flash('success', 'Erro ao atualizar portifólio');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT01Portfolios  $PORT01Portfolios
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT01Portfolios $PORT01Portfolios)
    {
        storageDelete($PORT01Portfolios, 'path_image_box');
        storageDelete($PORT01Portfolios, 'path_image_left');
        storageDelete($PORT01Portfolios, 'path_image_right');
        storageDelete($PORT01Portfolios, 'path_image_testimonial');

        if($PORT01Portfolios->delete()){
            Session::flash('success', 'Portifólio deletado com sucessso');
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
        $PORT01Portfolioss = PORT01Portfolios::whereIn('id', $request->deleteAll)->get();
        foreach($PORT01Portfolioss as $PORT01Portfolios){
            storageDelete($PORT01Portfolios, 'path_image_box');
            storageDelete($PORT01Portfolios, 'path_image_left');
            storageDelete($PORT01Portfolios, 'path_image_right');
            storageDelete($PORT01Portfolios, 'path_image_testimonial');
        }

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
        return view('Client.pages.Portfolios.PORT01.show');
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, PORT01PortfoliosCategory $PORT01PortfoliosCategory, PORT01PortfoliosSubategory $PORT01PortfoliosSubategory)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Portfolios', 'PORT01');

        return view('Client.pages.Portfolios.PORT01.page',[
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
        $portfolios = PORT01Portfolios::active()->sorting()->get();
        $section = PORT01PortfoliosSection::active()->first();
        $categories = PORT01PortfoliosCategory::with('subcategories')->exists()->active()->sorting()->get();
        $subcategories = PORT01PortfoliosSubategory::exists()->active()->sorting()->get();

        return view('Client.pages.Portfolios.PORT01.section',[
            'portfolios' => $portfolios,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'section' => $section,
        ]);
    }
}
