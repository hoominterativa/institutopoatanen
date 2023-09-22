<?php

namespace App\Http\Controllers\Contacts;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contacts\COTA03Contacts;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COTA03Controller extends Controller
{
    protected $path = 'uploads/Contacts/COTA03/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = COTA03Contacts::sorting()->get();
        return view('Admin.cruds.Contacts.COTA03.index',[
            'contacts' => $contacts,
            'cropSetting' => getCropImage('Contacts', 'COTA03')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $compliances = getCompliance(null, 'id', 'title_page');
        return view('Admin.cruds.Contacts.COTA03.create', [
            'compliances' => $compliances,
            'cropSetting' => getCropImage('Contacts', 'COTA03')
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

        $arrayInputs = [];

        foreach ($data as $name => $value) {
            $arrayName = explode('_', $name);
            if($arrayName[0] == 'column'){
                $type = end($arrayName);
                $inputOption = str_replace('column', 'option', $name);
                $inputRequired = str_replace('column', 'required', $name);
                $option = '';
                if(isset($data[$inputOption])){
                    $option = $data[$inputOption];
                }
                if(isset($data[$inputRequired])){
                    $required = true;
                }
                $pushArray = [
                    $name => [
                        'placeholder' => $value,
                        'option' => $option,
                        'type' => $type,
                        'required' => $required?? false,
                    ]
                ];
                $arrayInputs = array_merge($arrayInputs, $pushArray);
            }
        }
        $jsonInputs = json_encode($arrayInputs);

        $data['inputs_form'] = $jsonInputs;
        $data['slug'] = Str::slug($request->title_banner);
        $data['active'] = $request->active?1:0;
        $data['link_button_content'] = isset($data['link_button_content']) ? $data['link_button_content'] : null;

        $path_image_banner_desktop = $helper->optimizeImage($request, 'path_image_banner_desktop', $this->path, null,100);
        if($path_image_banner_desktop) $data['path_image_banner_desktop'] = $path_image_banner_desktop;

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null,100);
        if($path_image_banner_mobile) $data['path_image_banner_mobile'] = $path_image_banner_mobile;

        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null,100);
        if($path_image_content) $data['path_image_content'] = $path_image_content;

        if($contact = COTA03Contacts::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.cota03.edit', ['COTA03Contacts' => $contact->id]);

        }else{
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Storage::delete($path_image_content);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contacts\COTA03Contacts  $COTA03Contacts
     * @return \Illuminate\Http\Response
     */
    public function edit(COTA03Contacts $COTA03Contacts)
    {

        $configForm = json_decode($COTA03Contacts->inputs_form);
        $compliances = getCompliance(null, 'id', 'title_page');

        return view('Admin.cruds.Contacts.COTA03.edit', [
            'contact' => $COTA03Contacts,
            'compliances' => $compliances,
            'configForm' => !is_array($configForm)?$configForm:null,
            'cropSetting' => getCropImage('Contacts', 'COTA03')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contacts\COTA03Contacts  $COTA03Contacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COTA03Contacts $COTA03Contacts)
    {
        $data = $request->all();
        $helper = new HelperArchive();
        $arrayInputs = [];

        foreach ($data as $name => $value) {
            $arrayName = explode('_', $name);
            if($arrayName[0] == 'column'){
                $type = end($arrayName);
                $inputOption = str_replace('column', 'option', $name);
                $inputRequired = str_replace('column', 'required', $name);
                $option = '';
                $required = false;

                if(isset($data[$inputOption])){
                    $option = $data[$inputOption];
                }
                if(isset($data[$inputRequired])){
                    $required = true;
                }

                $pushArray = [
                    $name => [
                        'placeholder' => $value,
                        'option' => $option,
                        'type' => $type,
                        'required' => $required?? false,
                    ]
                ];
                $arrayInputs = array_merge($arrayInputs, $pushArray);
            }
        }

        if(count($arrayInputs)){
            $jsonInputs = json_encode($arrayInputs);
            $data['inputs_form'] = $jsonInputs;
        }
        if($request->active){
            $data['active'] = $request->active?1:0;
        }

        $data['slug'] = Str::slug($request->title_banner);
        $data['link_button_content'] = isset($data['link_button_content']) ? $data['link_button_content'] : null;

        //Banner
        $path_image_banner_desktop = $helper->optimizeImage($request, 'path_image_banner_desktop', $this->path, null,100);
        if($path_image_banner_desktop){
            storageDelete($COTA03Contacts, 'path_image_banner_desktop');
            $data['path_image_banner_desktop'] = $path_image_banner_desktop;
        }
        if($request->delete_path_image_banner_desktop && !$path_image_banner_desktop){
            storageDelete($COTA03Contacts, 'path_image_banner_desktop');
            $data['path_image_banner_desktop'] = null;
        }

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null,100);
        if($path_image_banner_mobile){
            storageDelete($COTA03Contacts, 'path_image_banner_mobile');
            $data['path_image_banner_mobile'] = $path_image_banner_mobile;
        }
        if($request->delete_path_image_banner_mobile && !$path_image_banner_mobile){
            storageDelete($COTA03Contacts, 'path_image_banner_mobile');
            $data['path_image_banner_mobile'] = null;
        }

        //Content
        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null,100);
        if($path_image_content){
            storageDelete($COTA03Contacts, 'path_image_content');
            $data['path_image_content'] = $path_image_content;
        }
        if($request->delete_path_image_content && !$path_image_content){
            storageDelete($COTA03Contacts, 'path_image_content');
            $data['path_image_content'] = null;
        }

        if($COTA03Contacts->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Storage::delete($path_image_content);
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contacts\COTA03Contacts  $COTA03Contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(COTA03Contacts $COTA03Contacts)
    {
        storageDelete($COTA03Contacts, 'path_image_banner_desktop');
        storageDelete($COTA03Contacts, 'path_image_banner_mobile');
        storageDelete($COTA03Contacts, 'path_image_content');

        if($COTA03Contacts->delete()){
            Session::flash('success', 'Item deletado com sucessso');
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

        $COTA03Contactss = COTA03Contacts::whereIn('id', $request->deleteAll)->get();
        foreach($COTA03Contactss as $COTA03Contacts){
            storageDelete($COTA03Contacts, 'path_image_banner_desktop');
            storageDelete($COTA03Contacts, 'path_image_banner_mobile');
            storageDelete($COTA03Contacts, 'path_image_content');
        }

        if($deleted = COTA03Contacts::whereIn('id', $request->deleteAll)->delete()){
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
            COTA03Contacts::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Contacts\COTA03Contacts  $COTA03Contacts
     * @return \Illuminate\Http\Response
     */
    //public function show(COTA03Contacts $COTA03Contacts)
    public function show(COTA03Contacts $COTA03Contacts)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contacts', 'COTA03', 'show');

        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if($COTA03Contacts) $COTA03Contacts->path_image_banner_desktop = $COTA03Contacts->path_image_banner_mobile;
            break;
        }

        $compliance = getCompliance($COTA03Contacts->compliance_id??'0');

        return view('Client.pages.Contacts.COTA03.page',[
            'sections' => $sections,
            'contact' => $COTA03Contacts,
            'compliance' => $compliance,
            'inputs' => json_decode($COTA03Contacts->inputs_form)
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
        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $contact = COTA03Contacts::first();
                if($contact) $contact->path_image_banner_desktop = $contact->path_image_banner_mobile;
            break;
            default:
            $contact = COTA03Contacts::first();
            break;
        }

        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contacts', 'COTA03');

        $compliance = getCompliance($contact->compliance_id??'0');

        return view('Client.pages.Contacts.COTA03.page',[
            'sections' => $sections,
            'contact' => $contact,
            'compliance' => $compliance,
            'inputs' => $contact ? (json_decode($contact->inputs_form) ?? []) : [],
        ]);
    }
}
