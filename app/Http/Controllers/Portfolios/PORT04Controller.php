<?php

namespace App\Http\Controllers\Portfolios;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Portfolios\PORT04Portfolios;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Portfolios\PORT04PortfoliosSection;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portfolios\PORT04PortfoliosCategory;

class PORT04Controller extends Controller
{
    protected $path = 'uploads/Portfolios/PORT04/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = PORT04Portfolios::sorting()->get();
        $portfolioCategories = PORT04PortfoliosCategory::sorting()->get();
        $categories = PORT04PortfoliosCategory::exists()->sorting()->pluck('title', 'id');
        $section = PORT04PortfoliosSection::first();
        return view('Admin.cruds.Portfolios.PORT04.index',[
            'portfolios' => $portfolios,
            'portfolioCategories' => $portfolioCategories,
            'categories' => $categories,
            'section' => $section,
            'cropSetting' => getCropImage('Portfolios', 'PORT04')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PORT04PortfoliosCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Portfolios.PORT04.create', [
            'categories' => $categories,
            'cropSetting' => getCropImage('Portfolios', 'PORT04')
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

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($data['title']);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if($portfolios = PORT04Portfolios::create($data)){
            Session::flash('success', 'Portfólio cadastrado com sucesso');
            return redirect()->route('admin.port04.edit', ['PORT04Portfolios' => $portfolios->id ]);
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o portfólio');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portfolios\PORT04Portfolios  $PORT04Portfolios
     * @return \Illuminate\Http\Response
     */
    public function edit(PORT04Portfolios $PORT04Portfolios)
    {
        $categories = PORT04PortfoliosCategory::sorting()->pluck('title', 'id');

        return view('Admin.cruds.Portfolios.PORT02.edit', [
            'portfolio' => $PORT04Portfolios,
            'categories' => $categories,
            'cropSetting' => getCropImage('Portfolios', 'PORT04')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT04Portfolios  $PORT04Portfolios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT04Portfolios $PORT04Portfolios)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($data['title']);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($PORT04Portfolios, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($PORT04Portfolios, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($PORT04Portfolios, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($PORT04Portfolios, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($PORT04Portfolios->fill($data)->save()){
            Session::flash('success', 'Portfólio atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar o portfólio');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT04Portfolios  $PORT04Portfolios
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT04Portfolios $PORT04Portfolios)
    {
        storageDelete($PORT04Portfolios, 'path_image');
        storageDelete($PORT04Portfolios, 'path_image_icon');

        if($PORT04Portfolios->delete()){
            Session::flash('success', 'Portfólio deletado com sucessso');
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

        $PORT04Portfolioss = PORT04Portfolios::whereIn('id', $request->deleteAll)->get();
        foreach($PORT04Portfolioss as $PORT04Portfolios){
            storageDelete($PORT04Portfolios, 'path_image');
            storageDelete($PORT04Portfolios, 'path_image_icon');
        }

        if($deleted = PORT04Portfolios::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Portfólios deletados com sucessso']);
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
            PORT04Portfolios::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Portfolios\PORT04Portfolios  $PORT04Portfolios
     * @return \Illuminate\Http\Response
     */
    //public function show(PORT04Portfolios $PORT04Portfolios)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Portfolios', 'PORT04', 'show');

        return view('Client.pages.Portfolios.PORT04.show',[
            'sections' => $sections
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Portfolios', 'PORT04', 'page');

        return view('Client.pages.Portfolios.PORT04.page',[
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
        return view('Client.pages.Portfolios.PORT04.section');
    }
}
