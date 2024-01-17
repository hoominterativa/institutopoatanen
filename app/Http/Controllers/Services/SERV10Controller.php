<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV10Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV10Controller extends Controller
{
    protected $path = 'uploads/Services/SERV10/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = SERV10Services::sorting()->get();
        return view('Admin.cruds.Services.SERV10.index', [
            'services' => $services
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Services.SERV10.create', [
            'cropSetting' => getCropImage('Services', 'SERV10')
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

        $data['active'] = $request->active ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;

        if($request->title || $request->title_box) $data['slug'] = Str::slug($request->title. ' ' . ($request->title_box ? $request->title_box : ''));

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_icon_box = $helper->optimizeImage($request, 'path_image_icon_box', $this->path, null,100);
        if($path_image_icon_box) $data['path_image_icon_box'] = $path_image_icon_box;

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;



        if($service = SERV10Services::create($data)){
            Session::flash('success', 'Serviço cadastrado com sucesso');
            return redirect()->route('admin.serv10.edit', ['SERV10Services' => $service->id]);
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon_box);
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao cadastradar o serviço');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV10Services  $SERV10Services
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV10Services $SERV10Services)
    {
        return view('Admin.cruds.Services.SERV10.edit',[
            'service' => $SERV10Services,
            'cropSetting' => getCropImage('Services', 'SERV10')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV10Services  $SERV10Services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV10Services $SERV10Services)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;

        if($request->title || $request->title_box) $data['slug'] = Str::slug($request->title. ' ' .($request->title_box ? $request->title_box : ''));

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV10Services, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV10Services, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon_box = $helper->optimizeImage($request, 'path_image_icon_box', $this->path, null,100);
        if($path_image_icon_box){
            storageDelete($SERV10Services, 'path_image_icon_box');
            $data['path_image_icon_box'] = $path_image_icon_box;
        }
        if($request->delete_path_image_icon_box && !$path_image_icon_box){
            storageDelete($SERV10Services, 'path_image_icon_box');
            $data['path_image_icon_box'] = null;
        }

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box){
            storageDelete($SERV10Services, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($SERV10Services, 'path_image_box');
            $data['path_image_box'] = null;
        }

        if($SERV10Services->fill($data)->save()){
            Session::flash('success', 'Serviço atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_box);
            Storage::delete($path_image_icon_box);
            Session::flash('error', 'Erro ao atualizar o serviço');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV10Services  $SERV10Services
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV10Services $SERV10Services)
    {
        storageDelete($SERV10Services, 'path_image');
        storageDelete($SERV10Services, 'path_image_icon_box');
        storageDelete($SERV10Services, 'path_image');

        if($SERV10Services->delete()){
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

        $SERV10Servicess = SERV10Services::whereIn('id', $request->deleteAll)->get();
        foreach($SERV10Servicess as $SERV10Services){
            storageDelete($SERV10Services, 'path_image');
            storageDelete($SERV10Services, 'path_image_icon_box');
            storageDelete($SERV10Services, 'path_image_box');
        }

        if($deleted = SERV10Services::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' serviços deletados com sucessso']);
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
            SERV10Services::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Services\SERV10Services  $SERV10Services
     * @return \Illuminate\Http\Response
     */
    //public function show(SERV10Services $SERV10Services)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV10', 'show');

        return view('Client.pages.Services.SERV10.show',[
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV10', 'page');

        return view('Client.pages.Services.SERV10.page',[
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
        return view('Client.pages.Services.SERV10.section');
    }
}
