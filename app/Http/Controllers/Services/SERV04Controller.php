<?php

namespace App\Http\Controllers\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV04Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Services\SERV04ServicesTopic;
use App\Models\Services\SERV04ServicesSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV04ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;

class SERV04Controller extends Controller
{
    protected $path = 'uploads/Services/SERV04/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = SERV04Services::sorting()->paginate(10);
        $serviceCategories = SERV04ServicesCategory::paginate(10);
        $categories = SERV04ServicesCategory::exists()->sorting()->pluck('title', 'id');
        $section = SERV04ServicesSection::first();
        return view('Admin.cruds.Services.SERV04.index', [
            'services' => $services,
            'serviceCategories' => $serviceCategories,
            'categories' => $categories,
            'section' => $section,
            'cropSetting' => getCropImage('Services', 'SERV04')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = SERV04ServicesCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Services.SERV04.create', [
            'categories' => $categories,
            'cropSetting' => getCropImage('Services', 'SERV04')
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

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(SERV04Services::create($data)){
            Session::flash('success', 'Serviço cadastrado com sucesso');
            return redirect()->route('admin.serv04.index');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao cadastradar o serviço');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV04Services  $SERV04Services
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV04Services $SERV04Services)
    {
        $topics = SERV04ServicesTopic::sorting()->where('service_id', $SERV04Services->id)->paginate(10);
        $categories = SERV04ServicesCategory::pluck('title', 'id');
        return view('Admin.cruds.Services.SERV04.edit', [
            'service' => $SERV04Services,
            'categories' => $categories,
            'topics' => $topics,
            'cropSetting' => getCropImage('Services', 'SERV04')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV04Services  $SERV04Services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV04Services $SERV04Services)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV04Services, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV04Services, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($SERV04Services, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($SERV04Services, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box){
            storageDelete($SERV04Services, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($SERV04Services, 'path_image_box');
            $data['path_image_box'] = null;
        }


        if($SERV04Services->fill($data)->save()){
            Session::flash('success', 'Serviço atualizado com sucesso');
            return redirect()->route('admin.serv04.index');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao atualizar o serviço');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV04Services  $SERV04Services
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV04Services $SERV04Services)
    {
        storageDelete($SERV04Services, 'path_image');
        storageDelete($SERV04Services, 'path_image_icon');
        storageDelete($SERV04Services, 'path_image_box');

        if($SERV04Services->delete()){
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


        $SERV04Servicess = SERV04Services::whereIn('id', $request->deleteAll)->get();
        foreach($SERV04Servicess as $SERV04Services){
            storageDelete($SERV04Services, 'path_image');
            storageDelete($SERV04Services, 'path_image_icon');
            storageDelete($SERV04Services, 'path_image_box');
        }


        if($deleted = SERV04Services::whereIn('id', $request->deleteAll)->delete()){
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
            SERV04Services::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT



    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV04');

        return view('Client.pages.Services.SERV04.page',[
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
        return view('Client.pages.Services.SERV04.section');
    }
}
