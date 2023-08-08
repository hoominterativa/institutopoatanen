<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV07Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Services\SERV07ServicesBanner;
use App\Models\Services\SERV07ServicesSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV07ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Services\SERV07ServicesGalleryCategory;
use App\Models\Services\SERV07ServicesGalleryService;
use App\Models\Services\SERV07ServicesSectionCategory;
use App\Models\Services\SERV07ServicesTopicCategory;
use App\Models\Services\SERV07ServicesVideo;

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
        $section = SERV07ServicesSection::first();
        return view('Admin.cruds.Services.SERV07.index',[
            'services' => $services,
            'serviceCategories' => $serviceCategories,
            'categories' => $categories,
            'section' => $section,
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


        if($service = SERV07Services::create($data)){
            Session::flash('success', 'Serviço cadastrado com sucesso');
            return redirect()->route('admin.serv07.edit',['SERV07Services' => $service->id]);
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
        $galleriesService = SERV07ServicesGalleryService::where('service_id', $SERV07Services->id)->sorting()->get();
        return view('Admin.cruds.Services.SERV07.edit',[
            'service' => $SERV07Services,
            'categories' => $categories,
            'galleriesService' => $galleriesService,
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
        $galleries = SERV07ServicesGalleryService::where('service_id', $SERV07Services->id)->get();
        if ($galleries){
            foreach ($galleries as $gallery){
                storageDelete($gallery, 'path_image');
                $gallery->delete();
            }
        }

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
            $galleries = SERV07ServicesGalleryService::where('service_id', $SERV07Services->id)->get();
            if ($galleries){
                foreach ($galleries as $gallery){
                    storageDelete($gallery, 'path_image');
                    $gallery->delete();
                }
            }

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
    public function show(SERV07Services $SERV07Services, SERV07ServicesCategory $SERV07ServicesCategory, $slug = null)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV07', 'show');

        // $currentCategory = SERV07ServicesCategory::first();

        // if ($slug){
        //     $currentCategory = SERV07ServicesCategory::where('serv07_services_categories.slug', $slug)->first();
        //     dd($currentCategory);
        //     $services = SERV07Services::where('serv07_services.category_id', $currentCategory->id)->active()->sorting()->get();
        // }

        $services = SERV07Services::where('id', '!=', $SERV07ServicesCategory->id)->active()->sorting()->get();
        $galleries = SERV07ServicesGalleryService::where('service_id', $SERV07Services->id)->sorting()->get();

        // dd($SERV07ServicesCategory);
        return view('Client.pages.Services.SERV07.show',[
            'sections' => $sections,
            'service' => $SERV07Services,
            'galleries' => $galleries,
            'services' => $services,
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, SERV07ServicesCategory $SERV07ServicesCategory)
    {
        switch(deviceDetect()){
            case 'mobile':
            case 'tablet':
                $section = SERV07ServicesSection::activeBanner()->first();
                if($section){
                    $section->path_image_desktop = $section->path_image_mobile;
                }
            break;
            default:
                $section = SERV07ServicesSection::activeBanner()->first();
            break;
        }

        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV07', 'page');

        $categories = SERV07ServicesCategory::active()->exists()->sorting()->get();
        $sectionCategories = SERV07ServicesSectionCategory::where('category_id', $SERV07ServicesCategory->id)->active()->sorting()->get();
        $categoryGet = SERV07ServicesSectionCategory::with('category')->where('category_id', $SERV07ServicesCategory->id)->active()->sorting()->first();
        $videos = SERV07ServicesVideo::where('category_id', $SERV07ServicesCategory->id)->active()->sorting()->get();
        $galleries = SERV07ServicesGalleryCategory::where('category_id', $SERV07ServicesCategory->id)->sorting()->get();
        $topics = SERV07ServicesTopicCategory::where('category_id', $SERV07ServicesCategory->id)->active()->sorting()->get();
        $services = SERV07Services::where('category_id', $SERV07ServicesCategory->id)->active()->sorting()->get();

        return view('Client.pages.Services.SERV07.page',[
            'sections' => $sections,
            'section' => $section,
            'categories' => $categories,
            'sectionCategories' => $sectionCategories,
            'categoryGet' => $categoryGet,
            'videos' => $videos,
            'galleries' => $galleries,
            'topics' => $topics,
            'services' => $services,
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $section = SERV07ServicesSection::active()->first();
        $categories = SERV07ServicesCategory::active()->featured()->exists()->sorting()->get();
        $categoryFirst = SERV07ServicesCategory::active()->exists()->first();
        return view('Client.pages.Services.SERV07.section',[
            'section' => $section,
            'categoryFirst' => $categoryFirst,
            'categories' => $categories
        ]);
    }
}
