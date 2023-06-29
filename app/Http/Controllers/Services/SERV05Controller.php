<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV05Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Services\SERV05ServicesSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV05ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;

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
        $services = SERV05Services::sorting()->paginate(30);
        $serviceCategories = SERV05ServicesCategory::sorting()->paginate(10);
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
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($request->title . ($request->subtitle ? '-' . $request->subtitle : ''));

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if (SERV05Services::create($data)) {
            Session::flash('success', 'Serviço cadastrado com sucesso');
            return redirect()->route('admin.serv05.index');
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
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
        return view('Admin.cruds.Services.SERV05.edit', [
            'service' => $SERV05Services,
            'categories' => $categories,
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
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($request->title . ($request->subtitle ? '-' . $request->subtitle : ''));

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

        if ($SERV05Services->fill($data)->save()) {
            Session::flash('success', 'Serviço atualizado com sucesso');
        } else {
            Storage::delete($path_image_icon);
            Storage::delete($path_image);
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
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV05', 'show');

        return view('Client.pages.Services.SERV05.show', [
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV05', 'page');

        return view('Client.pages.Services.SERV05.page', [
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
        return view('Client.pages.Services.SERV05.section');
    }
}
