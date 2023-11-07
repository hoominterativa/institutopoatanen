<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV09Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Services\SERV09ServicesSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV09ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;

class SERV09Controller extends Controller
{
    protected $path = 'uploads/Services/SERV09/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = SERV09Services::sorting()->paginate(32);
        $serviceCategories = SERV09ServicesCategory::sorting()->paginate(10);
        $categories = SERV09ServicesCategory::exists()->sorting()->pluck('title', 'id');
        $section = SERV09ServicesSection::first();
        return view('Admin.cruds.Services.SERV09.index', [
            'services' => $services,
            'serviceCategories' => $serviceCategories,
            'categories' => $categories,
            'section' => $section,
            'cropSetting' => getCropImage('Services', 'SERV09')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = SERV09ServicesCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Services.SERV09.create', [
            'categories' => $categories,
            'cropSetting' => getCropImage('Services', 'SERV09')
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
        $data['active_banner'] = $request->active_banner ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;
        $data['slug'] = Str::slug($request->title);
        $data['price'] = (float) str_replace(',', '.', str_replace('.', '', $request->price));
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if($service = SERV09Services::create($data)){
            Session::flash('success', 'Serviço cadastrado com sucesso');
            return redirect()->route('admin.serv09.edit', ['SERV09Services' => $service->id]);
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar o serviço');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV09Services  $SERV09Services
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV09Services $SERV09Services)
    {
        $categories = SERV09ServicesCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Services.SERV09.edit', [
            'service' => $SERV09Services,
            'categories' => $categories,
            'cropSetting' => getCropImage('Services', 'SERV09')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV09Services  $SERV09Services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV09Services $SERV09Services)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['active_banner'] = $request->active_banner ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;
        $data['slug'] = Str::slug($request->title);
        $data['price'] = (float) str_replace(',', '.', str_replace('.', '', $request->price));
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV09Services, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV09Services, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop){
            storageDelete($SERV09Services, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($SERV09Services, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile){
            storageDelete($SERV09Services, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($SERV09Services, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        if($SERV09Services->fill($data)->save()){
            Session::flash('success', 'Serviço atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar o serviço');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV09Services  $SERV09Services
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV09Services $SERV09Services)
    {
        storageDelete($SERV09Services, 'path_image');
        storageDelete($SERV09Services, 'path_image_desktop');
        storageDelete($SERV09Services, 'path_image_mobile');

        if($SERV09Services->delete()){
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

        $SERV09Servicess = SERV09Services::whereIn('id', $request->deleteAll)->get();
        foreach($SERV09Servicess as $SERV09Services){
            storageDelete($SERV09Services, 'path_image');
            storageDelete($SERV09Services, 'path_image_desktop');
            storageDelete($SERV09Services, 'path_image_mobile');
        }

        if($deleted = SERV09Services::whereIn('id', $request->deleteAll)->delete()){
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
            SERV09Services::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Services\SERV09Services  $SERV09Services
     * @return \Illuminate\Http\Response
     */
    //public function show(SERV09Services $SERV09Services)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV09', 'show');

        return view('Client.pages.Services.SERV09.show',[
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV09', 'page');

        return view('Client.pages.Services.SERV09.page',[
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
        return view('Client.pages.Services.SERV09.section');
    }
}
