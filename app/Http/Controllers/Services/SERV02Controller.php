<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV02Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Services\SERV02ServicesSection;
use App\Models\Services\SERV02ServicesTopic;

class SERV02Controller extends Controller
{
    protected $path = 'uploads/Services/SERV02/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = SERV02Services::sorting()->get();
        $section = SERV02ServicesSection::first();
        return view('Admin.cruds.Services.SERV02.index', [
            'services' => $services,
            'section' => $section,
            'cropSetting' => getCropImage('Services', 'SERV02')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Services.SERV02.create',[
            'cropSetting' => getCropImage('Services', 'SERV02')
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
        $data['active_section'] = $request->active_section ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;
        if($request->title || $request->subtitle) $data['slug'] = Str::slug($request->title . ' ' . ($request->subtitle ? $request->subtitle : ''));
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;

        $path_image_icon_box = $helper->optimizeImage($request, 'path_image_icon_box', $this->path, null,100);
        if($path_image_icon_box) $data['path_image_icon_box'] = $path_image_icon_box;

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner) $data['path_image_desktop_banner'] = $path_image_desktop_banner;

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner) $data['path_image_mobile_banner'] = $path_image_mobile_banner;

        if ($service = SERV02Services::create($data)) {
            Session::flash('success', 'Serviço cadastrado com sucesso');
            return redirect()->route('admin.serv02.edit', ['SERV02Services' => $service->id]);
        } else {
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Storage::delete($path_image_box);
            Storage::delete($path_image_icon_box);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Session::flash('error', 'Erro ao cadastradar o serviço');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV02Services  $SERV02Services
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV02Services $SERV02Services)
    {
        $topics = SERV02ServicesTopic::where('service_id', $SERV02Services->id)->sorting()->get();
        return view('Admin.cruds.Services.SERV02.edit',[
            'service' => $SERV02Services,
            'topics' => $topics,
            'cropSetting' => getCropImage('Services', 'SERV02')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV02Services  $SERV02Services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV02Services $SERV02Services)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['active_banner'] = $request->active_banner ? 1 : 0;
        $data['active_section'] = $request->active_section ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;
        if($request->title || $request->subtitle) $data['slug'] = Str::slug($request->title . ' ' . ($request->subtitle ? $request->subtitle : ''));
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop){
            storageDelete($SERV02Services, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($SERV02Services, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile){
            storageDelete($SERV02Services, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($SERV02Services, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box){
            storageDelete($SERV02Services, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($SERV02Services, 'path_image_box');
            $data['path_image_box'] = null;
        }

        $path_image_icon_box = $helper->optimizeImage($request, 'path_image_icon_box', $this->path, null,100);
        if($path_image_icon_box){
            storageDelete($SERV02Services, 'path_image_icon_box');
            $data['path_image_icon_box'] = $path_image_icon_box;
        }
        if($request->delete_path_image_icon_box && !$path_image_icon_box){
            storageDelete($SERV02Services, 'path_image_icon_box');
            $data['path_image_icon_box'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner){
            storageDelete($SERV02Services, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if($request->delete_path_image_mobile_banner && !$path_image_mobile_banner){
            storageDelete($SERV02Services, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner){
            storageDelete($SERV02Services, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if($request->delete_path_image_desktop_banner && !$path_image_desktop_banner){
            storageDelete($SERV02Services, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        if ($SERV02Services->fill($data)->save()) {
            Session::flash('success', 'Serviço atualizado com sucesso');
        } else {
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Storage::delete($path_image_box);
            Storage::delete($path_image_icon_box);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Session::flash('error', 'Erro ao atualizar o serviço');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV02Services  $SERV02Services
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV02Services $SERV02Services)
    {
        $topics = SERV02ServicesTopic::where('service_id', $SERV02Services->id)->get();
        if ($topics->count()) {
            foreach ($topics as $topic) {
                storageDelete($topic, 'path_image');
                storageDelete($topic, 'path_image_icon');
                $topic->delete();
            }
        }

        storageDelete($SERV02Services, 'path_image_desktop');
        storageDelete($SERV02Services, 'path_image_mobile');
        storageDelete($SERV02Services, 'path_image_box');
        storageDelete($SERV02Services, 'path_image_icon_box');
        storageDelete($SERV02Services, 'path_image_desktop_banner');
        storageDelete($SERV02Services, 'path_image_mobile_banner');

        if ($SERV02Services->delete()) {
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

        $SERV02Servicess = SERV02Services::whereIn('id', $request->deleteAll)->get();
        foreach($SERV02Servicess as $SERV02Services){
            $topics = SERV02ServicesTopic::where('service_id', $SERV02Services->id)->get();
            if ($topics->count()) {
                foreach ($topics as $topic) {
                    storageDelete($topic, 'path_image');
                    storageDelete($topic, 'path_image_icon');
                    $topic->delete();
                }
            }
            
            storageDelete($SERV02Services, 'path_image_desktop');
            storageDelete($SERV02Services, 'path_image_mobile');
            storageDelete($SERV02Services, 'path_image_box');
            storageDelete($SERV02Services, 'path_image_icon_box');
            storageDelete($SERV02Services, 'path_image_desktop_banner');
            storageDelete($SERV02Services, 'path_image_mobile_banner');
        }

        if ($deleted = SERV02Services::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' serviços deletados com sucessso']);
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
            SERV02Services::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Services\SERV02Services  $SERV02Services
     * @return \Illuminate\Http\Response
     */
    //public function show(SERV02Services $SERV02Services)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV02', 'show');

        return view('Client.pages.Services.SERV02.show', [
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV02', 'page');

        return view('Client.pages.Services.SERV02.page', [
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
        return view('Client.pages.Services.SERV02.section');
    }
}
