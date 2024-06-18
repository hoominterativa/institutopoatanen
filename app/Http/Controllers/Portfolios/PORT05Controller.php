<?php

namespace App\Http\Controllers\Portfolios;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Portfolios\PORT05Portfolios;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Portfolios\PORT05PortfoliosSection;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portfolios\CategoryPortfolio;
use App\Models\Portfolios\PORT05PortfoliosCategory;
use App\Models\Portfolios\PORT05PortfoliosGallery;
use App\Models\Portfolios\PORT05PortfoliosTestimonial;

class PORT05Controller extends Controller
{
    protected $path = 'uploads/Portfolios/PORT05/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = PORT05Portfolios::sorting()->paginate(20);
        $categories = PORT05PortfoliosCategory::sorting()->get();
        $section = PORT05PortfoliosSection::sorting()->first();
        return view('Admin.cruds.Portfolios.PORT05.index', [
            'portfolios' => $portfolios,
            'categories' => $categories,
            'section' => $section,
            'cropSetting' => getCropImage('Portfolios', 'PORT05')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PORT05PortfoliosCategory::sorting()->get();
        // dd($categories);
        // $array = [];
        // foreach ($categories as $category) {
        //     $array [$category->id][$category->title] = $category->title;
        // }
        return view('Admin.cruds.Portfolios.PORT05.create', [
            'categories' => $categories,
            'cropSetting' => getCropImage('Portfolios', 'PORT05')
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

        $data['featured'] = $request->featured?1:0;
        $data['active'] = $request->active?1:0;
        $data['active_banner'] = $request->active_banner?1:0;
        if($request->title) $data['slug'] = Str::slug($data['title']);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner) $data['path_image_desktop_banner'] = $path_image_desktop_banner;

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner) $data['path_image_mobile_banner'] = $path_image_mobile_banner;

        if($portfolio = PORT05Portfolios::create($data)){
            // dd($request);
            if ($request->has('category_id')) {
                $categoryIds = $request->input('category_id');
                $portfolio->categories()->attach($categoryIds);
            }
            Session::flash('success', 'Portifólio cadastrado com sucesso');
            return redirect()->route('admin.port05.edit', ['PORT05Portfolios' => $portfolio->id]);
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Session::flash('error', 'Erro ao cadastradar o portifólio');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portfolios\PORT05Portfolios  $PORT05Portfolios
     * @return \Illuminate\Http\Response
     */
    public function edit(PORT05Portfolios $PORT05Portfolios)
    {
        $categories = PORT05PortfoliosCategory::sorting()->get();
        $galleries = PORT05PortfoliosGallery::where('portfolio_id', $PORT05Portfolios->id)->sorting()->get();
        $testimonials = PORT05PortfoliosTestimonial::where('portfolio_id', $PORT05Portfolios->id)->sorting()->get();
        return view('Admin.cruds.Portfolios.PORT05.edit', [
            'portfolio' => $PORT05Portfolios,
            'categories' => $categories,
            'galleries' => $galleries,
            'testimonials' => $testimonials,
            'cropSetting' => getCropImage('Portfolios', 'PORT05')

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT05Portfolios  $PORT05Portfolios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT05Portfolios $PORT05Portfolios)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['featured'] = $request->featured?1:0;
        $data['active'] = $request->active?1:0;
        $data['active_banner'] = $request->active_banner?1:0;
        if($request->title) $data['slug'] = Str::slug($data['title']);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($PORT05Portfolios, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($PORT05Portfolios, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner){
            storageDelete($PORT05Portfolios, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if($request->delete_path_image_desktop_banner && !$path_image_desktop_banner){
            storageDelete($PORT05Portfolios, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner){
            storageDelete($PORT05Portfolios, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if($request->delete_path_image_mobile_banner && !$path_image_mobile_banner){
            storageDelete($PORT05Portfolios, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }

        if($PORT05Portfolios->fill($data)->save()){
            if ($request->has('category_id')) {
                $categoryIds = $request->input('category_id');
                $PORT05Portfolios->categories()->sync($categoryIds);
            }else {
                $PORT05Portfolios->categories()->sync([]);
            }
            Session::flash('success', 'Portifólio atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Session::flash('error', 'Erro ao atualizar o portfólio');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT05Portfolios  $PORT05Portfolios
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT05Portfolios $PORT05Portfolios)
    {
        storageDelete($PORT05Portfolios, 'path_image');
        storageDelete($PORT05Portfolios, 'path_image_desktop_banner');
        storageDelete($PORT05Portfolios, 'path_image_mobile_banner');

        if($PORT05Portfolios->delete()){
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

        $PORT05Portfolioss = PORT05Portfolios::whereIn('id', $request->deleteAll)->get();
        foreach($PORT05Portfolioss as $PORT05Portfolios){
            storageDelete($PORT05Portfolios, 'path_image');
            storageDelete($PORT05Portfolios, 'path_image_desktop_banner');
            storageDelete($PORT05Portfolios, 'path_image_mobile_banner');
        }

        if($deleted = PORT05Portfolios::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' portifólios deletados com sucessso']);
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
            PORT05Portfolios::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Portfolios\PORT05Portfolios  $PORT05Portfolios
     * @return \Illuminate\Http\Response
     */
    //public function show(PORT05Portfolios $PORT05Portfolios)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Portfolio', 'PORT05', 'show');

        return view('Client.pages.Portfolios.PORT05.show',[
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Portfolio', 'PORT05', 'page');

        return view('Client.pages.Portfolios.PORT05.page',[
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
        return view('Client.pages.Portfolios.PORT05.section');
    }
}
