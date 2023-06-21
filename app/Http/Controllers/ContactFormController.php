<?php

namespace App\Http\Controllers;

use App\Models\Social;
use App\Models\ContactForm;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;

class ContactFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ContactForms = ContactForm::get();
        return view('Admin.cruds.contactForm.index',[
            'contactForms' => $ContactForms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modelsMain = config('modelsConfig.InsertModelsMain');
        $modelsForm = config('modelsConfig.ModelsForm');
        $socials = Social::get();
        $sessions = [];
        $pages = ['home' => 'Home'];
        foreach ($modelsMain as $models) {
            foreach ($models as $key => $model) {
                $nameModel = $model->config->titleMenu<>''?$model->config->titleMenu:$model->config->titlePanel;
                if($model->ViewListMenu){
                    $pages = array_merge($pages, [Str::slug($nameModel) => $nameModel]);
                }
                $sessions = array_merge($sessions, [$key => $nameModel]);
            }
        }

        // dd($modelsForm);

        return view('Admin.cruds.contactForm.create',[
            'sessions' => $sessions,
            'pages' => $pages,
            'modelsForm' => $modelsForm,
            'socials' => $socials,
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
        $path = 'uploads/contactForm/images/';
        $helperArchive = new HelperArchive();
        $data = $request->all();

        $arrayInputs = [];
        $arrayContents = [];

        foreach ($data['content'] as $name => $value) {
            $type = $data['type_'.$name];

            if($type=='image'){
                $value = $helperArchive->optimizeImage($request, $name, $path, null, 100);
            }

            $content = [
                $name => [
                    'value' => $value,
                    'type' => $type,
                ]
            ];
            $arrayContents = array_merge($arrayContents, $content);
        }

        foreach ($data as $name => $value) {
            $arrayName = explode('_', $name);
            if($arrayName[0] == 'column'){
                $type = end($arrayName);
                $inputOption = str_replace('column', 'option', $name);
                $option = '';
                if(isset($data[$inputOption])){
                    $option = $data[$inputOption];
                }
                $pushArray = [
                    $name => [
                        'placeholder' => $value,
                        'option' => $option,
                        'type' => $type,
                    ]
                ];
                $arrayInputs = array_merge($arrayInputs, $pushArray);
            }
        }
        $jsonInputs = json_encode($arrayInputs);
        $social = json_encode($request->social_id, true);

        $ContactForm = new ContactForm();

        $ContactForm->email = $request->email;
        $ContactForm->session = $request->session;
        $ContactForm->position = $request->position;
        $ContactForm->page = $request->page;
        $ContactForm->model = $request->model;
        $ContactForm->social_id = $social;
        $ContactForm->inputs = $jsonInputs;
        $ContactForm->content = json_encode($arrayContents);
        $ContactForm->external_structure = $request->external_structure;
        $ContactForm->save();

        Session::flash('success', 'Formulário atualizado com sucessso');
        return redirect()->route('admin.contactForm.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactForm  $ContactForm
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactForm $ContactForm)
    {
        $modelsMain = config('modelsConfig.InsertModelsMain');
        $modelsForm = config('modelsConfig.ModelsForm');
        $socials = Social::get();
        $sessions = [];
        $pages = ['home' => 'Home'];

        foreach ($modelsMain as $models) {
            foreach ($models as $key => $model) {
                $nameModel = $model->config->titleMenu<>''?$model->config->titleMenu:$model->config->titlePanel;
                if($model->ViewListMenu){
                    $pages = array_merge($pages, [Str::slug($nameModel) => $nameModel]);
                }
                $sessions = array_merge($sessions, [$key => $nameModel]);
            }
        }

        return view('Admin.cruds.contactForm.edit',[
            'contactForm' => $ContactForm,
            'sessions' => $sessions,
            'pages' => $pages,
            'configForm' => json_decode($ContactForm->inputs),
            'content' => json_decode($ContactForm->content),
            'modelsForm' => $modelsForm,
            'socials' => $socials,
            'socialsCheck' => json_decode($ContactForm->social_id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactForm  $ContactForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactForm $ContactForm)
    {
        // dd($request->all());
        $path = 'uploads/contactForm/images/';
        $helperArchive = new HelperArchive();
        $data = $request->all();

        $arrayInputs = [];
        $arrayContents = [];

        foreach ($data['content'] as $name => $value) {
            $type = $data['type_'.$name];

            if($type=='image'){
                $contentCurrent = json_decode($ContactForm->content);
                if($request->hasFile($name)){
                    Storage::delete($contentCurrent->$name->value);
                    $value = $helperArchive->optimizeImage($request, $name, $path, null, 100);
                }else{
                    if($request->has('delete_path_image_inner')){
                        Storage::delete($contentCurrent->$name->value);
                        $value = null;
                    }else{
                        $value = $contentCurrent->$name->value;
                    }
                }
            }

            $content = [
                $name => [
                    'value' => $value,
                    'type' => $type,
                ]
            ];
            $arrayContents = array_merge($arrayContents, $content);
        }

        foreach ($data as $name => $value) {
            $arrayName = explode('_', $name);
            if($arrayName[0] == 'column'){
                $type = end($arrayName);
                $inputOption = str_replace('column', 'option', $name);
                $option = '';
                if(isset($data[$inputOption])){
                    $option = $data[$inputOption];
                }
                $pushArray = [
                    $name => [
                        'placeholder' => $value,
                        'option' => $option,
                        'type' => $type,
                    ]
                ];
                $arrayInputs = array_merge($arrayInputs, $pushArray);
            }
        }

        $jsonInputs = json_encode($arrayInputs);
        $social = json_encode($request->social_id, true);

        $ContactForm->email = $request->email;
        $ContactForm->session = $request->session;
        $ContactForm->position = $request->position;
        $ContactForm->page = $request->page;
        $ContactForm->model = $request->model;
        $ContactForm->social_id = $social;
        $ContactForm->inputs = $jsonInputs;
        $ContactForm->content = json_encode($arrayContents);
        $ContactForm->external_structure = $request->external_structure;
        $ContactForm->save();

        Session::flash('success', 'Formulário atualizado com sucessso');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactForm  $ContactForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactForm $ContactForm)
    {
        if($ContactForm->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request)
    {
        if($deleted = ContactForm::whereIn('id', $request->deleteAll)->delete()){
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
            ContactForm::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    /**
     * Get section form.
     *
     * @return array
     */
    public static function section($page, $section=null)
    {
        $ContactForms = ContactForm::where('page', $page);

        if($section){
            $ContactForms = $ContactForms->where('session', $section);
        }

        $ContactForms = $ContactForms->get();

        $view = '<section id="contactFormTemplate">';

        foreach ($ContactForms as $ContactForm) {
            if($ContactForm->social_id){
                $socials = Social::whereIn('id', json_decode($ContactForm->social_id))->get();
            }
            $view .= view('Client.Components.contactForm',[
                'contactForm' => $ContactForm,
                'content' => json_decode($ContactForm->content),
                'inputs' => json_decode($ContactForm->inputs),
                'model' => $ContactForm->model,
                'socials' => $socials?? null
            ]);
        }

        $view .= '</section>';

        $response = [];

        if($ContactForms->count()){
            $response = [
                'view' => $view,
                'position' => $section?$ContactForm->position:null
            ];
        }

        return $response;
    }

    public static function sectionPage($page, $section=null, $all=null)
    {
        $ContactForms = ContactForm::where('page', $page);

        if($section){
            $ContactForms = $ContactForms->where('session', $section);
        }

        $ContactForms = $ContactForms->get();

        $view = '<section id="contactFormTemplate">';

        foreach ($ContactForms as $ContactForm) {
            if($ContactForm->social_id){
                $socials = Social::whereIn('id', json_decode($ContactForm->social_id))->get();
            }
            $view .= view('Client.Components.contactForm',[
                'contactForm' => $ContactForm,
                'inputs' => json_decode($ContactForm->inputs),
                'content' => json_decode($ContactForm->content),
                'model' => $ContactForm->model,
                'socials' => $socials?? null
            ]);
        }

        $view .= '</section>';

        $response = [];

        if($ContactForms->count()){
            $response = [
                'view' => $view,
                'position' => $section?$ContactForm->position:null
            ];
        }

        return $response;
    }

    public function getContentModel(Request $request)
    {
        $modelsForm = config('modelsConfig.ModelsForm');
        $model = $request->model;

        $view = view('Admin.cruds.contactForm.formContent',[
            'model' => $modelsForm->$model,
            'code' => $model
        ]);

        return $view;
    }
}
