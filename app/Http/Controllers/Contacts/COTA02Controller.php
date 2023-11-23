<?php

namespace App\Http\Controllers\Contacts;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contacts\COTA02Contacts;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Contacts\COTA02ContactsTopic;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COTA02Controller extends Controller
{
    protected $path = 'uploads/Contacts/COTA02/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = COTA02Contacts::sorting()->get();
        return view('Admin.cruds.Contacts.COTA02.index', [
            'contacts' => $contacts,
            'cropSetting' => getCropImage('Contacts', 'COTA02')
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
        return view('Admin.cruds.Contacts.COTA02.create', [
            'compliances' => $compliances,
            'cropSetting' => getCropImage('Contacts', 'COTA02')
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
        if($request->title_page) $data['slug'] = Str::slug($request->title_page);
        if($request->active) $data['active'] = $request->active?1:0;

        //Banner
        $path_image_banner_desktop = $helper->optimizeImage($request, 'path_image_banner_desktop', $this->path, null,100);
        if($path_image_banner_desktop) $data['path_image_banner_desktop'] = $path_image_banner_desktop;

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null,100);
        if($path_image_banner_mobile) $data['path_image_banner_mobile'] = $path_image_banner_mobile;

        //Topics
        $path_image_topic_desktop = $helper->optimizeImage($request, 'path_image_topic_desktop', $this->path, null,100);
        if($path_image_topic_desktop) $data['path_image_topic_desktop'] = $path_image_topic_desktop;

        $path_image_topic_mobile = $helper->optimizeImage($request, 'path_image_topic_mobile', $this->path, null,100);
        if($path_image_topic_mobile) $data['path_image_topic_mobile'] = $path_image_topic_mobile;

        //Forms
        $path_image_form_desktop = $helper->optimizeImage($request, 'path_image_form_desktop', $this->path, null,100);
        if($path_image_form_desktop) $data['path_image_form_desktop'] = $path_image_form_desktop;

        $path_image_form_mobile = $helper->optimizeImage($request, 'path_image_form_mobile', $this->path, null,100);
        if($path_image_form_mobile) $data['path_image_form_mobile'] = $path_image_form_mobile;

        if($contact = COTA02Contacts::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.cota02.edit', ['COTA02Contacts' => $contact->id]);

        }else{
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Storage::delete($path_image_topic_desktop);
            Storage::delete($path_image_topic_mobile);
            Storage::delete($path_image_form_desktop);
            Storage::delete($path_image_form_mobile);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contacts\COTA02Contacts  $COTA02Contacts
     * @return \Illuminate\Http\Response
     */
    public function edit(COTA02Contacts $COTA02Contacts)
    {
        $topics = COTA02ContactsTopic::where('contact_id', $COTA02Contacts->id)->sorting()->get();

        $configForm = json_decode($COTA02Contacts->inputs_form);
        $compliances = getCompliance(null, 'id', 'title_page');

        return view('Admin.cruds.Contacts.COTA02.edit', [
            'contact' => $COTA02Contacts,
            'topics' => $topics,
            'compliances' => $compliances,
            'configForm' => !is_array($configForm)?$configForm:null,
            'cropSetting' => getCropImage('Contacts', 'COTA02')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contacts\COTA02Contacts  $COTA02Contacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COTA02Contacts $COTA02Contacts)
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
        if($request->active) $data['active'] = $request->active?1:0;
        if($request->title_page) $data['slug'] = Str::slug($request->title_page);

        //Banner
        $path_image_banner_desktop = $helper->optimizeImage($request, 'path_image_banner_desktop', $this->path, null,100);
        if($path_image_banner_desktop){
            storageDelete($COTA02Contacts, 'path_image_banner_desktop');
            $data['path_image_banner_desktop'] = $path_image_banner_desktop;
        }
        if($request->delete_path_image_banner_desktop && !$path_image_banner_desktop){
            storageDelete($COTA02Contacts, 'path_image_banner_desktop');
            $data['path_image_banner_desktop'] = null;
        }

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null,100);
        if($path_image_banner_mobile){
            storageDelete($COTA02Contacts, 'path_image_banner_mobile');
            $data['path_image_banner_mobile'] = $path_image_banner_mobile;
        }
        if($request->delete_path_image_banner_mobile && !$path_image_banner_mobile){
            storageDelete($COTA02Contacts, 'path_image_banner_mobile');
            $data['path_image_banner_mobile'] = null;
        }

        //Topic
        $path_image_topic_desktop = $helper->optimizeImage($request, 'path_image_topic_desktop', $this->path, null,100);
        if($path_image_topic_desktop){
            storageDelete($COTA02Contacts, 'path_image_topic_desktop');
            $data['path_image_topic_desktop'] = $path_image_topic_desktop;
        }
        if($request->delete_path_image_topic_desktop && !$path_image_topic_desktop){
            storageDelete($COTA02Contacts, 'path_image_topic_desktop');
            $data['path_image_topic_desktop'] = null;
        }

        $path_image_topic_mobile = $helper->optimizeImage($request, 'path_image_topic_mobile', $this->path, null,100);
        if($path_image_topic_mobile){
            storageDelete($COTA02Contacts, 'path_image_topic_mobile');
            $data['path_image_topic_mobile'] = $path_image_topic_mobile;
        }
        if($request->delete_path_image_topic_mobile && !$path_image_topic_mobile){
            storageDelete($COTA02Contacts, 'path_image_topic_mobile');
            $data['path_image_topic_mobile'] = null;
        }

        //Form
        $path_image_form_desktop = $helper->optimizeImage($request, 'path_image_form_desktop', $this->path, null,100);
        if($path_image_form_desktop){
            storageDelete($COTA02Contacts, 'path_image_form_desktop');
            $data['path_image_form_desktop'] = $path_image_form_desktop;
        }
        if($request->delete_path_image_form_desktop && !$path_image_form_desktop){
            storageDelete($COTA02Contacts, 'path_image_form_desktop');
            $data['path_image_form_desktop'] = null;
        }

        $path_image_form_mobile = $helper->optimizeImage($request, 'path_image_form_mobile', $this->path, null,100);
        if($path_image_form_mobile){
            storageDelete($COTA02Contacts, 'path_image_form_mobile');
            $data['path_image_form_mobile'] = $path_image_form_mobile;
        }
        if($request->delete_path_image_form_mobile && !$path_image_form_mobile){
            storageDelete($COTA02Contacts, 'path_image_form_mobile');
            $data['path_image_form_mobile'] = null;
        }

        if($COTA02Contacts->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Storage::delete($path_image_topic_desktop);
            Storage::delete($path_image_topic_mobile);
            Storage::delete($path_image_form_desktop);
            Storage::delete($path_image_form_mobile);
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contacts\COTA02Contacts  $COTA02Contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(COTA02Contacts $COTA02Contacts)
    {
        storageDelete($COTA02Contacts, 'path_image_banner_desktop');
        storageDelete($COTA02Contacts, 'path_image_banner_mobile');
        storageDelete($COTA02Contacts, 'path_image_topic_desktop');
        storageDelete($COTA02Contacts, 'path_image_topic_mobile');
        storageDelete($COTA02Contacts, 'path_image_form_mobile');
        storageDelete($COTA02Contacts, 'path_image_form_desktop');

        $topics = COTA02ContactsTopic::where('contact_id', $COTA02Contacts->id)->get();
        if($topics->count()){
            foreach($topics as $topic) {
                storageDelete($topic, 'path_image_icon');
                $topics->delete();
            }
        }

        if($COTA02Contacts->delete()){
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
        $COTA02Contactss = COTA02Contacts::whereIn('id', $request->deleteAll)->get();
        foreach($COTA02Contactss as $COTA02Contacts){
            $topics = COTA02ContactsTopic::where('contact_id', $COTA02Contacts->id)->get();
            if($topics->count()){
                foreach($topics as $topic) {
                    storageDelete($topic, 'path_image_icon');
                    $topics->delete();
                }
            }

            storageDelete($COTA02Contacts, 'path_image_banner_desktop');
            storageDelete($COTA02Contacts, 'path_image_banner_mobile');
            storageDelete($COTA02Contacts, 'path_image_topic_desktop');
            storageDelete($COTA02Contacts, 'path_image_topic_mobile');
            storageDelete($COTA02Contacts, 'path_image_form_mobile');
            storageDelete($COTA02Contacts, 'path_image_form_desktop');
        }



        if($deleted = COTA02Contacts::whereIn('id', $request->deleteAll)->delete()){
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
            COTA02Contacts::where('id', $id)->update(['sorting' => $sorting]);
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
    public function show(Request $request, COTA02Contacts $COTA02Contacts)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contacts', 'COTA02');

        $compliance = getCompliance($COTA02Contacts->compliance_id??'0');
        $topics = COTA02ContactsTopic::where('contact_id', $COTA02Contacts->id )->active()->sorting()->get();

        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if($COTA02Contacts) {
                    $COTA02Contacts->path_image_banner_desktop = $COTA02Contacts->path_image_banner_mobile;
                    $COTA02Contacts->path_image_topic_desktop = $COTA02Contacts->path_image_topic_mobile;
                    $COTA02Contacts->path_image_form_desktop = $COTA02Contacts->path_image_form_mobile;
                }
                break;
        }

        return view('Client.pages.Contacts.COTA02.page',[
            'sections' => $sections,
            'contact' => $COTA02Contacts,
            'topics' => $topics,
            'compliance' => $compliance,
            'inputs' => json_decode($COTA02Contacts->inputs_form)
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contacts', 'COTA02');

        $contact = COTA02Contacts::first();
        $compliance = getCompliance($contact->compliance_id??'0');
        $topics = COTA02ContactsTopic::where('contact_id', $contact->id )->active()->sorting()->get();

        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if($contact) {
                    $contact->path_image_banner_desktop = $contact->path_image_banner_mobile;
                    $contact->path_image_topic_desktop = $contact->path_image_topic_mobile;
                    $contact->path_image_form_desktop = $contact->path_image_form_mobile;
                }
            break;
        }

        return view('Client.pages.Contacts.COTA02.page',[
            'sections' => $sections,
            'contact' => $contact,
            'topics' => $topics,
            'compliance' => $compliance,
            'inputs' => $contact ? (json_decode($contact->inputs_form) ?? []) : [],
        ]);
    }
}
