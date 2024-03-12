<?php

namespace App\Http\Controllers\Contacts;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contacts\COTA05Contacts;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Contacts\COTA05ContactsAssessment;
use App\Http\Controllers\IncludeSectionsController;

class COTA05Controller extends Controller
{
    protected $path = 'uploads/Contacts/COTA05/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = COTA05Contacts::sorting()->get();
        return view('Admin.cruds.Contacts.COTA05.index', ['contacts' => $contacts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $compliances = getCompliance(null, 'id', 'title_page');
        return view('Admin.cruds.Contacts.COTA05.create', [
            'compliances' => $compliances,
            'cropSetting' => getCropImage('Contacts', 'COTA05')
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

        if($request->title_page) $data['slug'] = Str::slug($request->title_page);

        $data['active'] = $request->active ? 1 : 0;
        $data['active_banner'] = $request->active_banner ? 1 : 0;
        $data['active_form'] = $request->active_form ? 1 : 0;

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner) $data['path_image_desktop_banner'] = $path_image_desktop_banner;

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner) $data['path_image_mobile_banner'] = $path_image_mobile_banner;

        $path_image_icon_form = $helper->optimizeImage($request, 'path_image_icon_form', $this->path, null,100);
        if($path_image_icon_form) $data['path_image_icon_form'] = $path_image_icon_form;

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

        if ($contact = COTA05Contacts::create($data)) {
            Session::flash('success', 'Informações cadastradas com sucesso');
            return redirect()->route('admin.cota05.edit', ['COTA05Contacts' => $contact->id]);
        } else {
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Storage::delete($path_image_icon_form);
            Session::flash('error', 'Erro ao cadastradar as informações');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contacts\COTA05Contacts  $COTA05Contacts
     * @return \Illuminate\Http\Response
     */
    public function edit(COTA05Contacts $COTA05Contacts)
    {
        $configForm = json_decode($COTA05Contacts->inputs_form);
        $configAssessments = json_decode($COTA05Contacts->inputs_assessments);
        $compliances = getCompliance(null, 'id', 'title_page');

        return view('Admin.cruds.Contacts.COTA05.edit', [
            'contact' => $COTA05Contacts,
            'compliances' => $compliances,
            'configForm' => !is_array($configForm) ? $configForm : null,
            'configAssessments' => !is_array($configAssessments) ? $configAssessments : null,
            'cropSetting' => getCropImage('Contacts', 'COTA05')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contacts\COTA05Contacts  $COTA05Contacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COTA05Contacts $COTA05Contacts)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        if($request->title_page) $data['slug'] = Str::slug($request->title_page);

        $data['active'] = $request->active ? 1 : 0;
        $data['active_banner'] = $request->active_banner ? 1 : 0;
        $data['active_form'] = $request->active_form ? 1 : 0;

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner){
            storageDelete($COTA05Contacts, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if($request->delete_path_image_desktop_banner && !$path_image_desktop_banner){
            storageDelete($COTA05Contacts, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner){
            storageDelete($COTA05Contacts, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if($request->delete_path_image_mobile_banner && !$path_image_mobile_banner){
            storageDelete($COTA05Contacts, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }

        $path_image_icon_form = $helper->optimizeImage($request, 'path_image_icon_form', $this->path, null,100);
        if($path_image_icon_form){
            storageDelete($COTA05Contacts, 'path_image_icon_form');
            $data['path_image_icon_form'] = $path_image_icon_form;
        }
        if($request->delete_path_image_icon_form && !$path_image_icon_form){
            storageDelete($COTA05Contacts, 'path_image_icon_form');
            $data['path_image_icon_form'] = null;
        }

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

        if ($COTA05Contacts->fill($data)->save()) {
            Session::flash('success', 'Informações atualizadas com sucesso');
        } else {
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Storage::delete($path_image_icon_form);
            Session::flash('error', 'Erro ao atualizar as informações');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contacts\COTA05Contacts  $COTA05Contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(COTA05Contacts $COTA05Contacts)
    {
        storageDelete($COTA05Contacts, 'path_image_desktop_banner');
        storageDelete($COTA05Contacts, 'path_image_mobile_banner');
        storageDelete($COTA05Contacts, 'path_image_icon_form');

        if ($COTA05Contacts->delete()) {
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

        $COTA05Contactss = COTA05Contacts::whereIn('id', $request->deleteAll)->get();
        foreach($COTA05Contactss as $COTA05Contacts){
            storageDelete($COTA05Contacts, 'path_image_desktop_banner');
            storageDelete($COTA05Contacts, 'path_image_mobile_banner');
            storageDelete($COTA05Contacts, 'path_image_icon_form');
        }

        if ($deleted = COTA05Contacts::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' itens deletados com sucessso']);
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
            COTA05Contacts::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Contacts\COTA05Contacts  $COTA05Contacts
     * @return \Illuminate\Http\Response
     */
    //public function show(COTA05Contacts $COTA05Contacts)
    public function show(COTA05Contacts $COTA05Contacts)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contacts', 'COTA05', 'show');

        $compliance = getCompliance($COTA05Contacts->compliance_id ?? '0');

        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if($COTA05Contacts) $COTA05Contacts->path_image_desktop_banner = $COTA05Contacts->path_image_mobile_banner;
            break;
        }

        return view('Client.pages.Contacts.COTA05.page', [
            'sections' => $sections,
            'contact' => $COTA05Contacts,
            'compliance' => $compliance,
            'inputs' => json_decode($COTA05Contacts->inputs_form),
            'assessments' => json_decode($COTA05Contacts->inputs_assessments)
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contacts', 'COTA05', 'page');

        $contact = COTA05Contacts::active()->sorting()->first();
        $compliance = getCompliance($contact->compliance_id ?? '0');

        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if($contact) $contact->path_image_desktop_banner = $contact->path_image_mobile_banner;
            break;
        }

        return view('Client.pages.Contacts.COTA05.page', [
            'sections' => $sections,
            'contact' => $contact,
            'compliance' => $compliance,
            'assessments' => $contact ? (json_decode($contact->inputs_assessments) ?? []) : [],
            'inputs' => $contact ? (json_decode($contact->inputs_form) ?? []) : [],
        ]);
    }
}
