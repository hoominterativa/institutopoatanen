<?php

namespace App\Http\Controllers\Portfolios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Portfolios\PORT02Portfolios;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Portfolios\PORT02PortfoliosBanner;
use App\Models\Portfolios\PORT02PortfoliosSection;
use App\Http\Controllers\IncludeSectionsController;

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
        $section = PORT02PortfoliosSection::first();
        $banner = PORT02PortfoliosBanner::first();
        return view('Admin.cruds.Portfolios.PORT02.index', [
            'portfolios' => $portfolios,
            'section' => $section,
            'banner' => $banner,
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
        return view('Admin.cruds.Portfolios.PORT02.create', [
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

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;

        if(PORT02Portfolios::create($data)){
            Session::flash('success', 'Portfólio cadastrado com sucesso');
            return redirect()->route('admin.port02.index');
        }else{
            Storage::delete($path_image_box);
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
        return view('Admin.cruds.Portfolios.PORT02.edit', [
            'portfolio' => $PORT02Portfolios,
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

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box){
            storageDelete($PORT02Portfolios, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image && !$path_image_box){
            storageDelete($PORT02Portfolios, 'path_image_box');
            $data['path_image_box'] = null;
        }

        if($PORT02Portfolios->fill($data)->save()){
            Session::flash('success', 'Portfólio atualizado com sucesso');
            return redirect()->route('admin.port02.index');
        }else{
            Storage::delete($path_image_box);
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
        storageDelete($PORT02Portfolios, 'path_image_box');

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
            storageDelete($PORT02Portfolios, 'path_image_box');
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
        return view('');
    }
}
