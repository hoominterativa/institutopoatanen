<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV05Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Services\SERV05ServicesTopic;
use App\Models\Services\SERV05ServicesContent;
use App\Models\Services\SERV05ServicesGallery;
use App\Models\Services\SERV05ServicesSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV05ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Services\SERV05ServicesGalleryService;

class SERV05Controller extends Controller
{
    protected $path = 'uploads/Services/SERV05/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = SERV05Services::sorting()->get();
        $serviceCategories = SERV05ServicesCategory::sorting()->get();
        $categories = SERV05ServicesCategory::exists()->sorting()->pluck('title', 'id');
        $section = SERV05ServicesSection::first();
        return view('Admin.cruds.Services.SERV05.index', [
            'services' => $services,
            'categories' => $categories,
            'serviceCategories' => $serviceCategories,
            'section' => $section,
            'cropSetting' => getCropImage('Services', 'SERV05')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = SERV05ServicesCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Services.SERV05.create', [
            'categories' => $categories,
            'cropSetting' => getCropImage('Services', 'SERV05')
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
        $data['active_topic'] = $request->active_topic?1:0;
        $data['active_about_inner'] = $request->active_about?1:0;
        $data['active_banner'] = $request->active_banner?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($request->title . ($request->subtitle ? '-' . $request->subtitle : ''));

        if($request->price) $data['price'] = (float) str_replace(',', '.', str_replace('.', '', $request->price));

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if ($service = SERV05Services::create($data)) {
            Session::flash('success', 'Serviço cadastrado com sucesso');
            return redirect()->route('admin.serv05.edit', ['SERV05Services' => $service->id]);
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar o serviço');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV05Services  $SERV05Services
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV05Services $SERV05Services)
    {
        $categories = SERV05ServicesCategory::sorting()->pluck('title', 'id');
        $contents = SERV05ServicesContent::where('service_id', $SERV05Services->id)->sorting()->get();
        $topics = SERV05ServicesTopic::where('service_id', $SERV05Services->id)->sorting()->get();
        return view('Admin.cruds.Services.SERV05.edit', [
            'service' => $SERV05Services,
            'categories' => $categories,
            'contents' => $contents,
            'topics' => $topics,
            'cropSetting' => getCropImage('Services', 'SERV05')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV05Services  $SERV05Services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV05Services $SERV05Services)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['active_topic'] = $request->active_topic?1:0;
        $data['active_about_inner'] = $request->active_about?1:0;
        $data['active_banner'] = $request->active_banner?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($request->title . ($request->subtitle ? '-' . $request->subtitle : ''));

        if($request->price) $data['price'] = (float) str_replace(',', '.', str_replace('.', '', $request->price));

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV05Services, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV05Services, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($SERV05Services, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($SERV05Services, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop){
            storageDelete($SERV05Services, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($SERV05Services, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile){
            storageDelete($SERV05Services, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($SERV05Services, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        if ($SERV05Services->fill($data)->save()) {
            Session::flash('success', 'Serviço atualizado com sucesso');
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar o serviço');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV05Services  $SERV05Services
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV05Services $SERV05Services)
    {


        storageDelete($SERV05Services, 'path_image');
        storageDelete($SERV05Services, 'path_image_icon');
        storageDelete($SERV05Services, 'path_image_desktop');
        storageDelete($SERV05Services, 'path_image_mobile');

        if ($SERV05Services->delete()) {
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

        $SERV05Servicess = SERV05Services::whereIn('id', $request->deleteAll)->get();
        foreach($SERV05Servicess as $SERV05Services){
            storageDelete($SERV05Services, 'path_image');
            storageDelete($SERV05Services, 'path_image_icon');
            storageDelete($SERV05Services, 'path_image_desktop');
            storageDelete($SERV05Services, 'path_image_mobile');
        }

        if ($deleted = SERV05Services::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' Serviços deletados com sucessso']);
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
        foreach ($request->arrId as $sorting => $id) {
            SERV05Services::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Services\SERV05Services  $SERV05Services
     * @return \Illuminate\Http\Response
     */
    //public function show(SERV05Services $SERV05Services)
    public function show(SERV05Services $SERV05Services)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV05', 'show');

        $contents = SERV05ServicesContent::where('service_id', $SERV05Services->id)->active()->sorting()->get();
        $topics = SERV05ServicesTopic::where('service_id', $SERV05Services->id)->active()->sorting()->get();

        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($SERV05Services) $SERV05Services->path_image_desktop = $SERV05Services->path_image_mobile;
            break;

        }

        return view('Client.pages.Services.SERV05.show', [
            'sections' => $sections,
            'service' => $SERV05Services,
            'contents' => $contents,
            'topics' => $topics
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, SERV05ServicesCategory $SERV05ServicesCategory, SERV05Services $SERV05Services)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV05', 'page');

        if(!$SERV05ServicesCategory->exists){ $SERV05ServicesCategory = SERV05ServicesCategory::exists()->sorting()->active()->first(); }

        $section = SERV05ServicesSection::first();
        $categories = SERV05ServicesCategory::active()->exists()->sorting()->get();
        $services = SERV05Services::where('category_id', $SERV05ServicesCategory->id)->active()->sorting()->paginate(12);

        foreach($services as $service) {
            $service->price = $service->price ? number_format($service->price, '2', ',', '.') : null;
        }

        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($section) $section->path_image_desktop_banner = $section->path_image_mobile_banner;
            break;

        }

        return view('Client.pages.Services.SERV05.page', [
            'sections' => $sections,
            'section' => $section,
            'categories' => $categories,
            'services' => $services
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $section = SERV05ServicesSection::active()->first();
        $categories = SERV05ServicesCategory::active()->featured()->exists()->sorting()->get();
        $categoryFirst = SERV05ServicesCategory::active()->featured()->exists()->sorting()->first();
        $services = SERV05Services::active()->featured()->sorting()->get();
        return view('Client.pages.Services.SERV05.section',[
            'section' => $section,
            'categories' => $categories,
            'services' => $services,
            'categoryFirst' => $categoryFirst,
        ]);
    }
}
