<?php

namespace App\Http\Controllers\Contacts;

use App\Models\Contacts\COTA01ContactsTopicForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COTA01TopicFormController extends Controller
{
    protected $path = 'uploads/Contacts/COTA01/images/';

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

        $data['active'] = $request->active?1:0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(COTA01ContactsTopicForm::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao cadastradar tópico');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contacts\COTA01ContactsTopicForm  $COTA01ContactsTopicForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COTA01ContactsTopicForm $COTA01ContactsTopicForm)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon){
            storageDelete($COTA01ContactsTopicForm, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($COTA01ContactsTopicForm, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($COTA01ContactsTopicForm->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao atualizar tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contacts\COTA01ContactsTopicForm  $COTA01ContactsTopicForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(COTA01ContactsTopicForm $COTA01ContactsTopicForm)
    {
        storageDelete($COTA01ContactsTopicForm, 'path_image_icon');
        if($COTA01ContactsTopicForm->delete()){
            Session::flash('success', 'Tópico deletado com sucessso');
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
        $COTA01ContactsTopicForms = COTA01ContactsTopicForm::whereIn('id', $request->deleteAll)->get();
        foreach($COTA01ContactsTopicForms as $COTA01ContactsTopicForm){
            storageDelete($COTA01ContactsTopicForm, 'path_image_icon');
        }

        if($deleted = COTA01ContactsTopicForm::whereIn('id', $request->deleteAll)->delete()){
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
            COTA01ContactsTopicForm::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
