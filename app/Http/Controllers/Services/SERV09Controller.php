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
use App\Models\Services\SERV09ServicesContent;
use App\Models\Services\SERV09ServicesFeedback;
use App\Models\Services\SERV09ServicesGallery;
use App\Models\Services\SERV09ServicesTopic;
use Database\Factories\Services\SERV09ServicesFactory;

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
        $topics = SERV09ServicesTopic::where('service_id', $SERV09Services->id)->get();
        $galleries = SERV09ServicesGallery::where('service_id', $SERV09Services->id)->get();
        $contents = SERV09ServicesContent::where('service_id', $SERV09Services->id)->get();
        $feedbacks = SERV09ServicesFeedback::where('service_id', $SERV09Services->id)->get();
        return view('Admin.cruds.Services.SERV09.edit', [
            'service' => $SERV09Services,
            'categories' => $categories,
            'topics' => $topics,
            'galleries' => $galleries,
            'contents' => $contents,
            'feedbacks' => $feedbacks,
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
        $topics = SERV09ServicesTopic::where('service_id', $SERV09Services->id)->get();
        if ($topics->count()) {
            foreach ($topics as $topic) {
                storageDelete($topic, 'path_images');
                $topic->delete();
            }
        }

        $galleries = SERV09ServicesGallery::where('service_id', $SERV09Services->id)->get();
        if ($galleries->count()) {
            foreach ($galleries as $gallery) {
                storageDelete($gallery, 'path_images');
                $gallery->delete();
            }
        }

        $contents = SERV09ServicesContent::where('service_id', $SERV09Services->id)->get();
        if ($contents->count()) {
            foreach ($contents as $content) {
                $content->delete();
            }
        }

        $feedbacks = SERV09ServicesFeedback::where('service_id', $SERV09Services->id)->get();
        if ($feedbacks->count()) {
            foreach ($feedbacks as $feedback) {
                storageDelete($feedback, 'path_images');
                $feedback->delete();
            }
        }

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
            $topics = SERV09ServicesTopic::where('service_id', $SERV09Services->id)->get();
            if ($topics->count()) {
                foreach ($topics as $topic) {
                    storageDelete($topic, 'path_images');
                    $topic->delete();
                }
            }

            $galleries = SERV09ServicesGallery::where('service_id', $SERV09Services->id)->get();
            if ($galleries->count()) {
                foreach ($galleries as $gallery) {
                    storageDelete($gallery, 'path_images');
                    $gallery->delete();
                }
            }

            $contents = SERV09ServicesContent::where('service_id', $SERV09Services->id)->get();
            if ($contents->count()) {
                foreach ($contents as $content) {
                    $content->delete();
                }
            }

            $feedbacks = SERV09ServicesFeedback::where('service_id', $SERV09Services->id)->get();
            if ($feedbacks->count()) {
                foreach ($feedbacks as $feedback) {
                    storageDelete($feedback, 'path_images');
                    $feedback->delete();
                }
            }

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
    public function show($SERV09ServicesCategory, SERV09Services $SERV09Services)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV09', 'show');

        $category = SERV09ServicesCategory::where('slug', $SERV09ServicesCategory)->first();
        $service = SERV09Services::where(['category_id' => $category->id, 'id' => $SERV09Services->id])->first();
        $categories = SERV09ServicesCategory::active()->exists()->sorting()->get();
        $services = SERV09Services::with(['topics' => function ($query) {$query->where(['featured' => 1, 'active' => 1]);}])->whereNotIn('id', [$SERV09Services->id])->active()->sorting()->get();
        $topics = SERV09ServicesTopic::where('service_id', $SERV09Services->id)->active()->sorting()->get();
        $galleries = SERV09ServicesGallery::where('service_id', $SERV09Services->id)->sorting()->get();
        $contents = SERV09ServicesContent::where('service_id', $SERV09Services->id)->active()->sorting()->get();
        $feedbacks = SERV09ServicesFeedback::where('service_id', $SERV09Services->id)->active()->sorting()->get();
        $section = SERV09ServicesSection::active()->first();

        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($service)
                    {$service->path_image_desktop = $service->path_image_mobile;}
            break;
        }

        return view('Client.pages.Services.SERV09.show',[
            'sections' => $sections,
            'service' => $service,
            'topics' => $topics,
            'galleries' => $galleries,
            'contents' => $contents,
            'feedbacks' => $feedbacks,
            'section' => $section,
            'categories' => $categories,
            'services' => $services,
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, SERV09ServicesCategory $SERV09ServicesCategory, SERV09Services $SERV09Services)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV09', 'page');

        $section = SERV09ServicesSection::active()->first();
        $categories = SERV09ServicesCategory::active()->exists()->sorting()->get();
        $services = SERV09Services::active();
        if($SERV09ServicesCategory->exists){
            $services = $services->where('category_id', $SERV09ServicesCategory->id);

            foreach ($categories as $category) {
                if($SERV09ServicesCategory->id==$category->id){
                    $category->selected = true;
                }
            }
        }
        $services = $services->with(['topics' => function ($query) {$query->where(['featured' => 1, 'active' => 1]);}])->active()->sorting()->paginate(16);

        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($section)
                    {$section->path_image_desktop = $section->path_image_mobile;}
            break;
        }

        return view('Client.pages.Services.SERV09.page',[
            'sections' => $sections,
            'section' => $section,
            'categories' => $categories,
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
        $section = SERV09ServicesSection::active()->first();
        $categories = SERV09ServicesCategory::active()->featured()->exists()->sorting()->get();
        $categoryFirst = SERV09ServicesCategory::active()->exists()->first();
        $services = SERV09Services::with(['topics' => function ($query) {$query->where(['featured' => 1, 'active' => 1]);}])->active()->featured()->sorting()->get();
        return view('Client.pages.Services.SERV09.section',[
            'section' => $section,
            'categories' => $categories,
            'categoryFirst' => $categoryFirst,
            'services' => $services,
        ]);
    }
}
