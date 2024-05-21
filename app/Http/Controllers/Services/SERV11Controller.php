<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV11Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Services\SERV11ServicesSection;
use App\Models\Services\SERV11ServicesSession;

class SERV11Controller extends Controller
{
    protected $path = 'uploads/Services/SERV11/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service = SERV11Services::sorting()->paginate(32);
        $sessions = SERV11ServicesSession::sorting()->get();
        $section = SERV11ServicesSection::sorting()->first();

        return view('Admin.cruds.Services.SERV11.index', [
            'services' => $service,
            'sessions' => $sessions,
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
        $sessions = SERV11ServicesSession::sorting()->pluck('title', 'id');

        return view('Admin.cruds.Services.SERV11.create', [
            'sessions' => $sessions,
            'cropSetting' => getCropImage('Services', 'SERV11')
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

        if($request->title || $request->subtitle) $data['slug'] = Str::slug($request->title. ' ' . ($request->subtitle ?? ''));

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(SERV11Services::create($data)){
            Session::flash('success', 'Serviço cadastrado com sucesso');
            return redirect()->route('admin.serv11.index');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image_box);
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o serviço');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV11Services  $SERV11Services
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV11Services $SERV11Services)
    {
        $sessions = SERV11ServicesSession::sorting()->pluck('title', 'id');

        return view('Admin.cruds.Services.SERV11.edit', [
            'service' => $SERV11Services,
            'sessions' => $sessions,
            'cropSetting' => getCropImage('Services', 'SERV11')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV11Services  $SERV11Services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV11Services $SERV11Services)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;

        if($request->title || $request->subtitle) $data['slug'] = Str::slug($request->title. ' ' . ($request->subtitle ?? ''));

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($SERV11Services, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($SERV11Services, 'path_image_icon');
            $data['path_image_icon'] = null;
        }
        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box){
            storageDelete($SERV11Services, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($SERV11Services, 'path_image_box');
            $data['path_image_box'] = null;
        }

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV11Services, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV11Services, 'path_image');
            $data['path_image'] = null;
        }


        if($SERV11Services->fill($data)->save()){
            Session::flash('success', 'Serviço atualizado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image_box);
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar o serviço');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV11Services  $SERV11Services
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV11Services $SERV11Services)
    {
        storageDelete($SERV11Services, 'path_image_icon');
        storageDelete($SERV11Services, 'path_image_box');
        storageDelete($SERV11Services, 'path_image');

        if($SERV11Services->delete()){
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

        $SERV11Servicess = SERV11Services::whereIn('id', $request->deleteAll)->get();
        foreach($SERV11Servicess as $SERV11Services){
            storageDelete($SERV11Services, 'path_image_icon');
            storageDelete($SERV11Services, 'path_image_box');
            storageDelete($SERV11Services, 'path_image');
        }

        if($deleted = SERV11Services::whereIn('id', $request->deleteAll)->delete()){
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
            SERV11Services::where('id', $id)->update(['sorting' => $sorting]);
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV11', 'page');

        $sessions = SERV11ServicesSession::with('services')->exists()->active()->sorting()->get();
        $section = SERV11ServicesSection::activeBanner()->sorint()->first();

        return view('Client.pages.Services.SERV11.page',[
            'sections' => $sections,
            'sessions' => $sessions,
            'section' => $section
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $services = SERV11Services::active()->featured()->sorting()->get();
        $section = SERV11ServicesSection::activeSection()->sorint()->first();

        return view('Client.pages.Services.SERV11.section', [
            'services' => $services,
            'section' => $section
        ]);
    }
}
