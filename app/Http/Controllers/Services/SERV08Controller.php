<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV08Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Services\SERV08ServicesContact;
use App\Models\Services\SERV08ServicesSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV08ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;

class SERV08Controller extends Controller
{
    protected $path = 'uploads/Services/SERV08/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = SERV08Services::sorting()->paginate(32);
        $serviceCategories = SERV08ServicesCategory::sorting()->paginate(10);
        $categories = SERV08ServicesCategory::exists()->sorting()->pluck('title', 'id');
        $section = SERV08ServicesSection::first();
        $compliances = getCompliance(null, 'id', 'title_page');
        $contact = SERV08ServicesContact::first();
        $configForm = null;
        if ($contact) {
            $configForm = $contact->inputs_form ? json_decode($contact->inputs_form) : [];
        }
        return view('Admin.cruds.Services.SERV08.index', [
            'services' => $services,
            'serviceCategories' => $serviceCategories,
            'categories' => $categories,
            'section' => $section,
            'compliances' => $compliances,
            'contact' => $contact,
            'configForm' => !is_array($configForm)?$configForm:null,
            'cropSetting' => getCropImage('Services', 'SERV08')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = SERV08ServicesCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Services.SERV08.create', [
            'categories' => $categories,
            'cropSetting' => getCropImage('Services', 'SERV08')
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
        $data['featured_service'] = $request->featured_service ? 1 : 0;
        $data['slug'] = Str::slug($request->title);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(SERV08Services::create($data)){
            Session::flash('success', 'Serviço cadastrado com sucesso');
            return redirect()->route('admin.serv08.index');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o serviço');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV08Services  $SERV08Services
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV08Services $SERV08Services)
    {
        $categories = SERV08ServicesCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Services.SERV08.edit', [
            'service' => $SERV08Services,
            'categories' => $categories,
            'cropSetting' => getCropImage('Services', 'SERV08')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV08Services  $SERV08Services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV08Services $SERV08Services)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;
        $data['featured_service'] = $request->featured_service ? 1 : 0;
        $data['slug'] = Str::slug($request->title);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV08Services, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV08Services, 'path_image');
            $data['path_image'] = null;
        }

        if($SERV08Services->fill($data)->save()){
            Session::flash('success', 'Serviço atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar o serviço');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV08Services  $SERV08Services
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV08Services $SERV08Services)
    {
        storageDelete($SERV08Services, 'path_image');

        if($SERV08Services->delete()){
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
        $SERV08Servicess = SERV08Services::whereIn('id', $request->deleteAll)->get();
        foreach($SERV08Servicess as $SERV08Services){
            storageDelete($SERV08Services, 'path_image');
        }

        if($deleted = SERV08Services::whereIn('id', $request->deleteAll)->delete()){
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
            SERV08Services::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Services\SERV08Services  $SERV08Services
     * @return \Illuminate\Http\Response
     */
    //public function show(SERV08Services $SERV08Services)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV08', 'show');

        return view('Client.pages.Services.SERV08.show',[
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Services', 'SERV08', 'page');

        return view('Client.pages.Services.SERV08.page',[
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
        $section = SERV08ServicesSection::active()->first();
        $categories = SERV08ServicesCategory::active()->featured()->sorting()->get();
        $services = SERV08Services::active()->featured()->sorting()->get();
        return view('Client.pages.Services.SERV08.section',[
            'section' => $section,
            'categories' => $categories,
            'services' => $services,
        ]);
    }
}
