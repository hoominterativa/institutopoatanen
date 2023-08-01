<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV07Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV07ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;

class SERV07Controller extends Controller
{
    protected $path = 'uploads/Services/SERV07/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = SERV07Services::sorting()->paginate(30);
        $serviceCategories = SERV07ServicesCategory::sorting()->paginate(10);
        $categories = SERV07ServicesCategory::exists()->sorting()->pluck('title', 'id');
        return view('Admin.cruds.Services.SERV07.index',[
            'services' => $services,
            'serviceCategories' => $serviceCategories,
            'categories' => $categories,
            'cropSetting' => getCropImage('Services', 'SERV07')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = SERV07ServicesCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Services.SERV07.create',[
            'categories' => $categories,
            'cropSetting' => getCropImage('Services', 'SERV07')
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
        $data['link_button'] = isset($data['link_button']) ?getUri($data['link_button']) : null;
        $data['slug'] = Str::slug($request->title . ($request->subtitle ? '-' . $request->subtitle : ''));

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;


        if(SERV07Services::create($data)){
            Session::flash('success', 'Serviço cadastrado com sucesso');
            return redirect()->route('admin.serv07.index');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao cadastradar o serviço');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV07Services  $SERV07Services
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV07Services $SERV07Services)
    {
        $categories = SERV07ServicesCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Services.SERV07.edit',[
            'service' => $SERV07Services,
            'categories' => $categories,
            'cropSetting' => getCropImage('Services', 'SERV07')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV07Services  $SERV07Services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV07Services $SERV07Services)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['link_button'] = isset($data['link_button']) ?getUri($data['link_button']) : null;
        $data['slug'] = Str::slug($request->title . ($request->subtitle ? '-' . $request->subtitle : ''));

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV07Services, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV07Services, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box){
            storageDelete($SERV07Services, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($SERV07Services, 'path_image_box');
            $data['path_image_box'] = null;
        }

        if($SERV07Services->fill($data)->save()){
            Session::flash('success', 'Serviço atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao atualizar o serviço');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV07Services  $SERV07Services
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV07Services $SERV07Services)
    {
        storageDelete($SERV07Services, 'path_image');
        storageDelete($SERV07Services, 'path_image_box');

        if($SERV07Services->delete()){
            Session::flash('success', 'Serviço deletado com sucessso');
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

        $SERV07Servicess = SERV07Services::whereIn('id', $request->deleteAll)->get();
        foreach($SERV07Servicess as $SERV07Services){
            storageDelete($SERV07Services, 'path_image');
            storageDelete($SERV07Services, 'path_image_box');
        }

        if($deleted = SERV07Services::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Serviços deletados com sucessso']);
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
            SERV07Services::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Services\SERV07Services  $SERV07Services
     * @return \Illuminate\Http\Response
     */
    //public function show(SERV07Services $SERV07Services)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV07', 'show');

        return view('Client.pages.Services.SERV07.show',[
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV07', 'page');

        return view('Client.pages.Services.SERV07.page',[
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
        return view('Client.pages.Services.SERV07.section');
    }
}
