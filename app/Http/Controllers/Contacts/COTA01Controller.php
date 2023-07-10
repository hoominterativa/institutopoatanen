<?php

namespace App\Http\Controllers\Contacts;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contacts\COTA01Contacts;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Contacts\COTA01ContactsTopic;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Contacts\COTA01ContactsTopicForm;
use App\Http\Controllers\IncludeSectionsController;

class COTA01Controller extends Controller
{
    protected $path = 'uploads/Contacts/COTA01/images/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = COTA01Contacts::sorting()->get();
        return view('Admin.cruds.Contacts.COTA01.index',[
            'contacts' => $contacts
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
        return view('Admin.cruds.Contacts.COTA01.create',[
            'compliances' => $compliances,
            'cropSetting' => getCropImage('Contacts', 'COTA01')
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
        $helper = new HelperArchive();
        $data = $request->all();
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
        $data['active'] = $request->active?1:0;

        $data['slug'] = Str::slug($request->title_page);

        $path_image_banner = $helper->optimizeImage($request, 'path_image_banner', $this->path, null, 100);
        if($path_image_banner) $data['path_image_banner'] = $path_image_banner;

        $path_image_section_topic = $helper->optimizeImage($request, 'path_image_section_topic', $this->path, null, 100);
        if($path_image_section_topic) $data['path_image_section_topic'] = $path_image_section_topic;

        if($contact = COTA01Contacts::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
            return redirect()->route('admin.cota01.edit', ['COTA01Contacts' => $contact->id]);
        }else{
            Storage::delete($path_image_banner);
            Storage::delete($path_image_section_topic);
            Session::flash('error', 'Erro ao cadastradar informações');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contacts\COTA01Contacts  $COTA01Contacts
     * @return \Illuminate\Http\Response
     */
    public function edit(COTA01Contacts $COTA01Contacts)
    {
        $topicsForm = COTA01ContactsTopicForm::sorting()->get();
        $sectionTopics = COTA01ContactsTopic::sorting()->get();

        $configForm = json_decode($COTA01Contacts->inputs_form);
        $compliances = getCompliance(null, 'id', 'title_page');

        return view('Admin.cruds.Contacts.COTA01.edit',[
            'contact' => $COTA01Contacts,
            'topicsForm' => $topicsForm,
            'topicsSection' => $sectionTopics,
            'compliances' => $compliances,
            'configForm' => !is_array($configForm)?$configForm:null,
            'cropSetting' => getCropImage('Contacts', 'COTA01')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contacts\COTA01Contacts  $COTA01Contacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COTA01Contacts $COTA01Contacts)
    {
        $helper = new HelperArchive();
        $data = $request->all();
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

        $data['slug'] = Str::slug($request->title_page);

        $path_image_banner = $helper->optimizeImage($request, 'path_image_banner', $this->path, null, 100);
        if($path_image_banner){
            storageDelete($COTA01Contacts, 'path_image_banner');
            $data['path_image_banner'] = $path_image_banner;
        }
        if($request->delete_path_image_banner && !$path_image_banner){
            storageDelete($COTA01Contacts, 'path_image_banner');
            $data['path_image_banner'] = null;
        }

        $path_image_section_topic = $helper->optimizeImage($request, 'path_image_section_topic', $this->path, null, 100);
        if($path_image_section_topic){
            storageDelete($COTA01Contacts, 'path_image_section_topic');
            $data['path_image_section_topic'] = $path_image_section_topic;
        }
        if($request->delete_path_image_section_topic && !$path_image_section_topic){
            storageDelete($COTA01Contacts, 'path_image_section_topic');
            $data['path_image_section_topic'] = null;
        }

        if($COTA01Contacts->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image_banner);
            Storage::delete($path_image_section_topic);
            Session::flash('success', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contacts\COTA01Contacts  $COTA01Contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(COTA01Contacts $COTA01Contacts)
    {
        storageDelete($COTA01Contacts, 'path_image_banner');
        storageDelete($COTA01Contacts, 'path_image_section_topic');

        $topicsForm = COTA01ContactsTopicForm::where('contact_id', $COTA01Contacts->id)->get();
        if($topicsForm->count()){
            $topicsForm->delete();
        }

        $topics = COTA01ContactsTopic::where('contact_id', $COTA01Contacts->id)->get();
        if($topics->count()){
            $topics->delete();
        }

        if($COTA01Contacts->delete()){
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
        $COTA01Contactss = COTA01Contacts::whereIn('id', $request->deleteAll)->get();
        foreach($COTA01Contactss as $COTA01Contacts){
            storageDelete($COTA01Contacts, 'path_image_banner');
            storageDelete($COTA01Contacts, 'path_image_section_topic');

            $topicsForm = COTA01ContactsTopicForm::where('contact_id', $COTA01Contacts->id)->get();
            if($topicsForm->count()){
                $topicsForm->delete();
            }

            $topics = COTA01ContactsTopic::where('contact_id', $COTA01Contacts->id)->get();
            if($topics->count()){
                $topics->delete();
            }

            if($COTA01Contacts->delete()){
                Session::flash('success', 'Item deletado com sucessso');
                return redirect()->back();
            }
        }

        if($deleted = COTA01Contacts::whereIn('id', $request->deleteAll)->delete()){
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
            COTA01Contacts::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Services\COTA01Contacts  $COTA01Contacts
     * @return \Illuminate\Http\Response
     */
    public function page(COTA01Contacts $COTA01Contacts)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contacts', 'COTA01');
        $contact = COTA01Contacts::with(['topicsSection', 'topicsForms'])->active()->sorting()->first();
        $compliance = getCompliance($contact->compliance_id??'0');

        return view('Client.pages.Contacts.COTA01.show',[
            'contact' => $contact,
            'sections' => $sections,
            'compliance' => $compliance,
            'inputs' => $contact ? (json_decode($contact->inputs_form) ?? []) : [],
        ]);
    }
}
