<?php

namespace App\Http\Controllers;

use App\Models\ContactForm;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

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
        $ModelsForm = config('modelsConfig.ModelsForm');
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Session::flash('success', 'Item cadastrado com sucessso');
        return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactForm  $ContactForm
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactForm $ContactForm)
    {
        $modelsMain = Config::get('modelsConfig.InsertModelsMain');
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
            'configForm' => json_decode($ContactForm->inputs)
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

        $ContactForm->after_session = $request->after_session;
        $ContactForm->page = $request->page;
        $ContactForm->model = $request->model;
        $ContactForm->inputs = $jsonInputs;
        $ContactForm->external_structure = $request->external_structure;
        $ContactForm->save();

        Session::flash('success', 'Configuração atualizada com sucessso');
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

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContactForm  $ContactForm
     * @return \Illuminate\Http\Response
     */
    public function show(ContactForm $ContactForm)
    {
        //
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        //
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        return view('');
    }
}
