<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV06Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Services\SERV06ServicesBanner;
use App\Models\Services\SERV06ServicesSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV06ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;

class SERV06Controller extends Controller
{
    protected $path = 'uploads/Services/SERV06/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = SERV06Services::sorting()->get();
        $serviceCategories = SERV06ServicesCategory::get();
        $categories = SERV06ServicesCategory::exists()->sorting()->pluck('title', 'id');
        $section = SERV06ServicesSection::first();
        $banner = SERV06ServicesBanner::first();
        return view('Admin.cruds.Services.SERV06.index', [
            'services' => $services,
            'serviceCategories' => $serviceCategories,
            'categories' => $categories,
            'section' => $section,
            'banner' => $banner,
            'cropSetting' => getCropImage('Services', 'SERV06')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = SERV06ServicesCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Services.SERV06.create', [
            'categories' => $categories,
            'cropSetting' => getCropImage('Services', 'SERV06')
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
        $data['slug'] = Str::slug($request->title);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if (SERV06Services::create($data)) {
            Session::flash('success', 'Serviço cadastrado com sucesso');
            return redirect()->route('admin.serv06.index');
        } else {
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o serviço');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV06Services  $SERV06Services
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV06Services $SERV06Services)
    {
        $categories = SERV06ServicesCategory::pluck('title', 'id');
        return view('Admin.cruds.Services.SERV06.edit', [
            'service' => $SERV06Services,
            'categories' => $categories,
            'cropSetting' => getCropImage('Services', 'SERV06')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV06Services  $SERV06Services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV06Services $SERV06Services)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->title);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV06Services, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV06Services, 'path_image');
            $data['path_image'] = null;
        }

        if ($SERV06Services->fill($data)->save()) {
            Session::flash('success', 'Serviço atualizado com sucesso');
        } else {
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar serviço');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV06Services  $SERV06Services
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV06Services $SERV06Services)
    {
        storageDelete($SERV06Services, 'path_image');

        if ($SERV06Services->delete()) {
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
        $SERV06Servicess = SERV06Services::whereIn('id', $request->deleteAll)->get();
        foreach($SERV06Servicess as $SERV06Services){
            storageDelete($SERV06Services, 'path_image');
        }

        if ($deleted = SERV06Services::whereIn('id', $request->deleteAll)->delete()) {
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
            SERV06Services::where('id', $id)->update(['sorting' => $sorting]);
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
    public function page(Request $request, SERV06ServicesCategory $SERV06ServicesCategory)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV06', 'page');

        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $banner = SERV06ServicesBanner::active()->first();
                if($banner) {
                    $banner->path_image_desktop = $banner->path_image_mobile;
                }
            break;
            default:
            $banner = SERV06ServicesBanner::active()->first();
            break;
        }

        $categories = SERV06ServicesCategory::exists()->active()->sorting()->get();
        $services = SERV06Services::active()->sorting()->get();

        return view('Client.pages.Services.SERV06.page', [
            'sections' => $sections,
            'banner' => $banner,
            'services' => $services,
            'categories' => $categories
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $section = SERV06ServicesSection::active()->first();
                if($section) {
                    $section->path_image_desktop = $section->path_image_mobile;
                }
            break;
            default:
            $section = SERV06ServicesSection::active()->first();
            break;
        }

        return view('Client.pages.Services.SERV06.section', [
            'section' => $section,
        ]);
    }
}
