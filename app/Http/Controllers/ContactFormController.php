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
        // dd($request->all());
        $path = 'uploads/images/contactForm/';
        $helperArchive = new HelperArchive();
        $path_image = $helperArchive->optimizeImage($request, 'path_image',$path,400,90);
        $arrayInputs = [];
        $data = $request->all();

        foreach ($data as $name => $value) {
            $arrayName = explode('_', $name);
            if($arrayName[0] == 'title'){
                $type = end($arrayName);
                $inputOption = str_replace('title', 'option', $name);
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

        if($path_image){
            Storage::delete($ContactForm->path_image);
            $ContactForm->path_image = $path.$path_image;
            $request->path_image->storeAs($path, $path_image);
        }

        $ContactForm->email = $request->email;
        $ContactForm->session = $request->session;
        $ContactForm->position = $request->position;
        $ContactForm->page = $request->page;
        $ContactForm->model = $request->model;
        $ContactForm->section_title = $request->section_title;
        $ContactForm->description = $request->description;
        $ContactForm->social_id = $social;
        $ContactForm->inputs = $jsonInputs;
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
        $path = 'uploads/images/contactForm/';
        $helperArchive = new HelperArchive();
        $path_image = $helperArchive->optimizeImage($request, 'path_image',$path,400,90);
        $arrayInputs = [];
        $data = $request->all();
        foreach ($data as $name => $value) {
            $arrayName = explode('_', $name);
            if($arrayName[0] == 'title'){
                $type = end($arrayName);
                $inputOption = str_replace('title', 'option', $name);
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

        if($path_image){
            Storage::delete($ContactForm->path_image);
            $ContactForm->path_image = $path.$path_image;
            $request->path_image->storeAs($path, $path_image);
        }

        $ContactForm->email = $request->email;
        $ContactForm->session = $request->session;
        $ContactForm->position = $request->position;
        $ContactForm->page = $request->page;
        $ContactForm->model = $request->model;
        $ContactForm->section_title = $request->section_title;
        $ContactForm->description = $request->description;
        $ContactForm->social_id = $social;
        $ContactForm->inputs = $jsonInputs;
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
    public static function section($section)
    {
        $ContactForms = ContactForm::where('session', $section)->get();

        $view = '<section id="contactFormTemplate">';

        foreach ($ContactForms as $ContactForm) {
            $socials = Social::whereIn('id', [$ContactForm->social_id])->get();
            $view .= view('Client.Components.contactForm',[
                'contactForm' => $ContactForm,
                'inputs' => json_decode($ContactForm->inputs),
                'model' => $ContactForm->model,
                'socials' => $socials
            ]);
        }

        $view .= '</section>';

        $response = [];

        if($ContactForms->count()){
            $response = [
                'view' => $view,
                'position' => $ContactForm->position
            ];
        }

        return $response;
    }
}
