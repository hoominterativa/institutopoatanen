<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV12Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV12ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Services\SERV12ServicesGallery;
use App\Models\Services\SERV12ServicesSection;
use App\Models\Services\SERV12ServicesTopic;
use App\Models\Services\SERV12ServicesVideo;

class SERV12Controller extends Controller
{
    protected $path = 'uploads/Services/SERV12/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = SERV12Services::sorting()->get();
        $categories = SERV12ServicesCategory::sorting()->get();
        $section = SERV12ServicesSection::sorting()->first();
        return view('Admin.cruds.Services.SERV12.index',[
            'cropSetting' => getCropImage('Services', 'SERV12'),
            'services' => $services,
            'categories' => $categories,
            'section' => $section
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = SERV12ServicesCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Services.SERV12.create', [
            'cropSetting' => getCropImage('Services', 'SERV12'),
            'categories' => $categories
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

        if ($request->title || $request->subtitle) $data['slug'] = Str::slug($request->title. ' ' .$request->subtitle ? $request->subtitle : '');

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if($service = SERV12Services::create($data)){
            Session::flash('success', 'Serviço cadastrado com sucesso');
            return redirect()->route('admin.serv12.edit', ['SERV12Services' => $service->id]);
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar o serviço');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV12Services  $SERV12Services
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV12Services $SERV12Services)
    {
        $categories = SERV12ServicesCategory::sorting()->pluck('title', 'id');
        $topics = SERV12ServicesTopic::where('service_id', $SERV12Services->id)->sorting()->get();
        $galleries = SERV12ServicesGallery::where('service_id', $SERV12Services->id)->sorting()->get();
        $video = SERV12ServicesVideo::where('service_id', $SERV12Services->id)->sorting()->first();
        return view('Admin.cruds.Services.SERV12.edit', [
            'cropSetting' => getCropImage('Services', 'SERV12'),
            'service' => $SERV12Services,
            'categories' => $categories,
            'topics' => $topics,
            'galleries' => $galleries,
            'video' => $video
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV12Services  $SERV12Services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV12Services $SERV12Services)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;

        if ($request->title || $request->subtitle) $data['slug'] = Str::slug($request->title. ' ' .$request->subtitle ? $request->subtitle : '');

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV12Services, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV12Services, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($SERV12Services, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($SERV12Services, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($SERV12Services->fill($data)->save()){
            Session::flash('success', 'Serviço atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar o serviço');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV12Services  $SERV12Services
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV12Services $SERV12Services)
    {
        storageDelete($SERV12Services, 'path_image');
        storageDelete($SERV12Services, 'path_image_icon');

        if($SERV12Services->delete()){
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

        $SERV12Servicess = SERV12Services::whereIn('id', $request->deleteAll)->get();
        foreach($SERV12Servicess as $SERV12Services){
            storageDelete($SERV12Services, 'path_image');
            storageDelete($SERV12Services, 'path_image_icon');
        }

        if($deleted = SERV12Services::whereIn('id', $request->deleteAll)->delete()){
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
            SERV12Services::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Services\SERV12Services  $SERV12Services
     * @return \Illuminate\Http\Response
     */
    //public function show(SERV12Services $SERV12Services)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV12', 'show');

        return view('Client.pages.Services.SERV12.show',[
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV12', 'page');

        return view('Client.pages.Services.SERV12.page',[
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
        $section = SERV12ServicesSection::active()->first();
        $categorySelected = SERV12ServicesCategory::exists()->active()->featured()->sorting()->first();
        $categories = SERV12ServicesCategory::exists()->active()->featured()->sorting()->get();
        $services = SERV12Services::with('category')->active()->featured()->sorting()->get();

        return view('Client.pages.Services.SERV12.section', [
            'section' => $section,
            'categories' => $categories,
            'categorySelected' => $categorySelected,
            'services' => $services
        ]);
    }
}
