<?php

namespace App\Http\Controllers\Portfolios;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Portfolios\PORT03Portfolios;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Portfolios\PORT03PortfoliosSection;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portfolios\PORT03PortfoliosCategory;

class PORT03Controller extends Controller
{
    protected $path = 'uploads/Portfolios/PORT03/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = PORT03Portfolios::sorting()->get();
        $portfolioCategories = PORT03PortfoliosCategory::sorting()->get();
        $categories = PORT03PortfoliosCategory::exists()->sorting()->pluck('title', 'id');
        $section = PORT03PortfoliosSection::first();
        return view('Admin.cruds.Portfolios.PORT03.index', [
            'portfolios' => $portfolios,
            'portfolioCategories' => $portfolioCategories,
            'categories' => $categories,
            'section' => $section,
            'cropSetting' => getCropImage('Portfolios', 'PORT03')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PORT03PortfoliosCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Portfolios.PORT03.create', [
            'categories' => $categories,
            'cropSetting' => getCropImage('Portfolios', 'PORT03')
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
        $data['slug'] = Str::slug($request->title);
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image_before = $helper->optimizeImage($request, 'path_image_before', $this->path, null,100);
        if($path_image_before) $data['path_image_before'] = $path_image_before;

        $path_image_after = $helper->optimizeImage($request, 'path_image_after', $this->path, null,100);
        if($path_image_after) $data['path_image_after'] = $path_image_after;

        if(PORT03Portfolios::create($data)){
            Session::flash('success', 'Portfólio cadastrado com sucesso');
            return redirect()->route('admin.port03.index');
        }else{
            Storage::delete($path_image_before);
            Storage::delete($path_image_after);
            Session::flash('error', 'Erro ao cadastradar o portfólio');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portfolios\PORT03Portfolios  $PORT03Portfolios
     * @return \Illuminate\Http\Response
     */
    public function edit(PORT03Portfolios $PORT03Portfolios)
    {
        $categories = PORT03PortfoliosCategory::sorting()->pluck('title', 'id');

        return view('Admin.cruds.Portfolios.PORT03.edit', [
            'portfolio' => $PORT03Portfolios,
            'categories' => $categories,
            'cropSetting' => getCropImage('Portfolios', 'PORT03')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT03Portfolios  $PORT03Portfolios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT03Portfolios $PORT03Portfolios)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($request->title);
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image_before = $helper->optimizeImage($request, 'path_image_before', $this->path, null,100);
        if($path_image_before){
            storageDelete($PORT03Portfolios, 'path_image_before');
            $data['path_image_before'] = $path_image_before;
        }
        if($request->delete_path_image_before && !$path_image_before){
            storageDelete($PORT03Portfolios, 'path_image_before');
            $data['path_image_before'] = null;
        }

        $path_image_after = $helper->optimizeImage($request, 'path_image_after', $this->path, null,100);
        if($path_image_after){
            storageDelete($PORT03Portfolios, 'path_image_after');
            $data['path_image_after'] = $path_image_after;
        }
        if($request->delete_path_image_after && !$path_image_after){
            storageDelete($PORT03Portfolios, 'path_image_after');
            $data['path_image_after'] = null;
        }

        if($PORT03Portfolios->fill($data)->save()){
            Session::flash('success', 'Portfólio atualizado com sucesso');

        }else{
            Storage::delete($path_image_before);
            Storage::delete($path_image_after);
            Session::flash('error', 'Erro ao atualizar o portfólio');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT03Portfolios  $PORT03Portfolios
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT03Portfolios $PORT03Portfolios)
    {

        storageDelete($PORT03Portfolios, 'path_image_before');
        storageDelete($PORT03Portfolios, 'path_image_after');

        if($PORT03Portfolios->delete()){
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
        $PORT03Portfolioss = PORT03Portfolios::whereIn('id', $request->deleteAll)->get();
        foreach($PORT03Portfolioss as $PORT03Portfolios){

            storageDelete($PORT03Portfolios, 'path_image_before');
            storageDelete($PORT03Portfolios, 'path_image_after');
        }

        if($deleted = PORT03Portfolios::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' portfólios deletados com sucessso']);
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
            PORT03Portfolios::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Portfolios\PORT03PortfoliosCategory  $PORT03PortfoliosCategory
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, PORT03PortfoliosCategory $PORT03PortfoliosCategory)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Portfolios', 'PORT03', 'page');

        $categories = PORT03PortfoliosCategory::active()->exists()->sorting()->get();
        $portfolios = PORT03Portfolios::active();

        if ($PORT03PortfoliosCategory->exists) {
            $portfolios = $portfolios->where('category_id', $PORT03PortfoliosCategory->id);
            foreach($categories as $category) {
                if ($PORT03PortfoliosCategory->id == $category->id) {
                    $category->selected = true;
                }
            }
        }
        $portfolios = $portfolios->sorting()->get();
        $section = PORT03PortfoliosSection::first();
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($section) $section->path_image_desktop = $section->path_image_mobile;
            break;
        }

        return view('Client.pages.Portfolios.PORT03.page', [
            'sections' => $sections,
            "portfolios" => $portfolios,
            "categories" => $categories,
            "section" => $section,
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $category = PORT03PortfoliosCategory::active()->exists()->first();
        $portfolios = PORT03Portfolios::active()->featured()->sorting()->get();
        $section = PORT03PortfoliosSection::active()->first();
        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if($section) $section->path_image_desktop = $section->path_image_mobile;
            break;
        }

        return view('Client.pages.Portfolios.PORT03.section',[
            "portfolios" => $portfolios,
            "section" => $section,
            'category' => $category
        ]);
    }
}
