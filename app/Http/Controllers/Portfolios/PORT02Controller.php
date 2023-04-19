<?php

namespace App\Http\Controllers\Portfolios;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Portfolios\PORT02Portfolios;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Portfolios\PORT02PortfoliosBanner;
use App\Models\Portfolios\PORT02PortfoliosGallery;
use App\Models\Portfolios\PORT02PortfoliosSection;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portfolios\PORT02PortfoliosCategory;
use App\Models\Portfolios\PORT02PortfoliosBannerHome;

class PORT02Controller extends Controller
{
    protected $path = 'uploads/Portfolios/PORT02/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = PORT02Portfolios::sorting()->paginate(20);
        $portfolioCategories = PORT02PortfoliosCategory::sorting()->paginate(20);
        $categories = PORT02PortfoliosCategory::exists()->sorting()->pluck('title', 'id');
        $section = PORT02PortfoliosSection::first();
        $banner = PORT02PortfoliosBanner::first();
        $bannerHome = PORT02PortfoliosBannerHome::first();
        return view('Admin.cruds.Portfolios.PORT02.index', [
            'portfolios' => $portfolios,
            'portfolioCategories' => $portfolioCategories,
            'categories' => $categories,
            'section' => $section,
            'banner' => $banner,
            'bannerHome' => $bannerHome,
            'cropSetting' => getCropImage('Portfolios', 'PORT02')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PORT02PortfoliosCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Portfolios.PORT02.create', [
            'categories' => $categories,
            'cropSetting' => getCropImage('Portfolios', 'PORT02')
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

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if($portfolios = PORT02Portfolios::create($data)){
            Session::flash('success', 'Portfólio cadastrado com sucesso');
            return redirect()->route('admin.port02.edit', ['PORT02Portfolios' => $portfolios->id ]);
        }else{
            Storage::delete($path_image_box);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar o portfólio');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portfolios\PORT02Portfolios  $PORT02Portfolios
     * @return \Illuminate\Http\Response
     */
    public function edit(PORT02Portfolios $PORT02Portfolios)
    {
        $galleries = PORT02PortfoliosGallery::where('portfolio_id', $PORT02Portfolios->id)->get();
        $categories = PORT02PortfoliosCategory::sorting()->pluck('title', 'id');

        return view('Admin.cruds.Portfolios.PORT02.edit', [
            'portfolio' => $PORT02Portfolios,
            'categories' => $categories,
            'galleries' => $galleries,
            'cropSetting' => getCropImage('Portfolios', 'PORT02')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT02Portfolios  $PORT02Portfolios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT02Portfolios $PORT02Portfolios)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($data['title']);

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box){
            storageDelete($PORT02Portfolios, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($PORT02Portfolios, 'path_image_box');
            $data['path_image_box'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($PORT02Portfolios, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_icon && !$path_image_icon){
            storageDelete($PORT02Portfolios, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop){
            storageDelete($PORT02Portfolios, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($PORT02Portfolios, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile){
            storageDelete($PORT02Portfolios, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($PORT02Portfolios, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        if($PORT02Portfolios->fill($data)->save()){
            Session::flash('success', 'Portfólio atualizado com sucesso');
            return redirect()->route('admin.port02.index');
        }else{
            Storage::delete($path_image_box);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar o portfólio');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT02Portfolios  $PORT02Portfolios
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT02Portfolios $PORT02Portfolios)
    {
        $galleries = PORT02PortfoliosGallery::where('portfolio_id', $PORT02Portfolios->id)->get();
        foreach($galleries as $gallery){
            storageDelete($gallery, 'path_image');
            $gallery->delete();
        }

        storageDelete($PORT02Portfolios, 'path_image_box');
        storageDelete($PORT02Portfolios, 'path_image_icon');
        storageDelete($PORT02Portfolios, 'path_image_desktop');
        storageDelete($PORT02Portfolios, 'path_image_mobile');

        if($PORT02Portfolios->delete()){
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
        $PORT02Portfolioss = PORT02Portfolios::whereIn('id', $request->deleteAll)->get();
        foreach($PORT02Portfolioss as $PORT02Portfolios){
            $galleries = PORT02PortfoliosGallery::where('portfolio_id', $PORT02Portfolios->id)->get();
            foreach($galleries as $gallery){
                storageDelete($gallery, 'path_image');
                $gallery->delete();
            }

            storageDelete($PORT02Portfolios, 'path_image_box');
            storageDelete($PORT02Portfolios, 'path_image_icon');
            storageDelete($PORT02Portfolios, 'path_image_desktop');
            storageDelete($PORT02Portfolios, 'path_image_mobile');
        }

        if($deleted = PORT02Portfolios::whereIn('id', $request->deleteAll)->delete()){
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
            PORT02Portfolios::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Portfolios\PORT02Portfolios  $PORT02Portfolios
     * @return \Illuminate\Http\Response
     */
    //public function show(PORT02Portfolios $PORT02Portfolios)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Module', 'Model');

        return view('Client.pages.Module.Model.show',[
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
        return view('Client.pages.Portfolios.PORT02.section');
    }
}
