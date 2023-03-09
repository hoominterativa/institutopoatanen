<?php

namespace App\Http\Controllers\Portfolios;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Portfolios\PORT101Portfolios;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class PORT101Controller extends Controller
{
    protected $path = 'uploads/Portfolios/PORT101/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = PORT101Portfolios::sorting()->active()->paginate(10);
        return view('Admin.cruds.Portfolios.PORT101.index', [
            'portfolios' => $portfolios,
            'cropSetting' => getCropImage('Portfolios', 'PORT101')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Portfolios.PORT101.create', [
            'cropSetting' => getCropImage('Portfolios', 'PORT101')
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
        $data['featured'] = $request->active?1:0;

        $colorDelete = array_search(end($data['colors']), $data['colors']);
        unset($data['colors'][$colorDelete]);
        $data['colors'] = implode(',', $data['colors']);
        $data['slug'] = Str::slug($data['title']);

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null, 100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if(PORT101Portfolios::create($data)){
            Session::flash('success', 'Portfólio cadastrado com sucesso');
            return redirect()->route('admin.port101.index');
        }else{
            Storage::delete($path_image_box);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar o portfólio');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portfolios\PORT101Portfolios  $PORT101Portfolios
     * @return \Illuminate\Http\Response
     */
    public function edit(PORT101Portfolios $PORT101Portfolios)
    {
        return view('Admin.cruds.Portfolios.PORT101.edit', [
            'portfolio' => $PORT101Portfolios,
            'cropSetting' => getCropImage('Portfolios', 'PORT101')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT101Portfolios  $PORT101Portfolios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT101Portfolios $PORT101Portfolios)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->active?1:0;

        $colorDelete = array_search(end($data['colors']), $data['colors']);
        unset($data['colors'][$colorDelete]);
        $data['colors'] = implode(',', $data['colors']);
        $data['slug'] = Str::slug($data['title']);

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null, 100);
        if($path_image_box){
            storageDelete($PORT101Portfolios, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($PORT101Portfolios, 'path_image_box');
            $data['path_image_box'] = null;
        }

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if($path_image_desktop){
            storageDelete($PORT101Portfolios, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($PORT101Portfolios, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if($path_image_mobile){
            storageDelete($PORT101Portfolios, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($PORT101Portfolios, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        if($PORT101Portfolios->fill($data)->save()){
            Session::flash('success', 'Portfólio atualizado com sucesso');
            return redirect()->route('admin.port101.index');
        }else{
            Storage::delete($path_image_box);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT101Portfolios  $PORT101Portfolios
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT101Portfolios $PORT101Portfolios)
    {
        storageDelete($PORT101Portfolios, 'path_image_box');
        storageDelete($PORT101Portfolios, 'path_image_desktop');
        storageDelete($PORT101Portfolios, 'path_image_mobile');

        if($PORT101Portfolios->delete()){
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


        $PORT101Portfolioss = PORT101Portfolios::whereIn('id', $request->deleteAll)->get();
        foreach($PORT101Portfolioss as $PORT101Portfolios){
            storageDelete($PORT101Portfolios, 'path_image_box');
            storageDelete($PORT101Portfolios, 'path_image_desktop');
            storageDelete($PORT101Portfolios, 'path_image_mobile');
        }


        if($deleted = PORT101Portfolios::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Portifólios deletados com sucessso']);
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
            PORT101Portfolios::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Portfolios\PORT101Portfolios  $PORT101Portfolios
     * @return \Illuminate\Http\Response
     */
    //public function show(PORT101Portfolios $PORT101Portfolios)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Portfolios', 'PORT101');

        return view('Client.pages.Portfolios.PORT101.show',[
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
        return view('Client.pages.Portfolios.PORT101.section');
    }
}
