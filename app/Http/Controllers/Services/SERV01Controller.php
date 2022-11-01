<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV01Services;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Services\SERV01ServicesAdvantage;
use App\Models\Services\SERV01ServicesAdvantageSection;
use App\Models\Services\SERV01ServicesSection;

class SERV01Controller extends Controller
{
    protected $path = 'uploads/Service/SERV01/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = SERV01Services::active()->sorting()->paginate();
        $section = SERV01ServicesSection::first();

        return view('Admin.cruds.Services.SERV01.index',[
            'services' => $services,
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
        return view('Admin.cruds.Services.SERV01.create');
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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, 400, 100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, 200, 100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;

        if(SERV01Services::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
            return redirect()->route('admin.serv01.index');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao cadastrar informações');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV01Services  $SERV01Services
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV01Services $SERV01Services)
    {
        $advantages = SERV01ServicesAdvantage::where('service_id', $SERV01Services->id)->get();
        $advantageSection = SERV01ServicesAdvantageSection::where('service_id', $SERV01Services->id)->first();

        return view('Admin.cruds.Services.SERV01.edit',[
            'service' => $SERV01Services,
            'advantages' => $advantages,
            'advantageSection' => $advantageSection,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV01Services  $SERV01Services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV01Services $SERV01Services)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, 400, 100);
        if($path_image){
            storageDelete($SERV01Services, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV01Services, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, 200, 100);
        if($path_image_icon){
            storageDelete($SERV01Services, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($SERV01Services, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($SERV01Services->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
            return redirect()->route('admin.serv01.index');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao atualizar informações');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV01Services  $SERV01Services
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV01Services $SERV01Services)
    {
        storageDelete($SERV01Services, 'path_image');
        storageDelete($SERV01Services, 'path_image_icon');

        if($SERV01Services->delete()){
            Session::flash('success', 'Registro deletado com sucesso');
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
        $SERV01Servicess = SERV01Services::whereIn('id', $request->deleteAll)->get();
        foreach($SERV01Servicess as $SERV01Services){
            storageDelete($SERV01Services, 'path_image');
            storageDelete($SERV01Services, 'path_image_icon');
        }

        if($deleted = SERV01Services::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
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
            SERV01Services::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Services\SERV01Services  $SERV01Services
     * @return \Illuminate\Http\Response
     */
    public function show(SERV01Services $SERV01Services)
    {
        $service = SERV01Services::with(['advantages','advantagesSection','portfolios','portfoliosSection'])->find($SERV01Services->id);
        return view('Client.pages.Services.SERV01.show',[
            'service' => $service
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV01');
        $services = SERV01Services::active()->sorting()->get();

        return view('Client.pages.Services.SERV01.page',[
            'sections' => $sections,
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
        $services = SERV01Services::active()->featured()->sorting()->get();
        return view('Client.pages.Services.SERV01.section',[
            'services' => $services,
        ]);
    }
}
