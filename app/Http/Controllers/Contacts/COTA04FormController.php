<?php

namespace App\Http\Controllers\Contacts;

use App\Models\Contacts\COTA04ContactsForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COTA04FormController extends Controller
{
    protected $path = 'uploads/Module/Code/images/';

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

        if(COTA04ContactsForm::create($data)){
            Session::flash('success', 'Formulário cadastrado com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar o formulário');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contacts\COTA04ContactsForm  $COTA04ContactsForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COTA04ContactsForm $COTA04ContactsForm)
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

        if($COTA04ContactsForm->fill($data)->save()){
            Session::flash('success', 'Formulário atualizado com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar o formulário');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contacts\COTA04ContactsForm  $COTA04ContactsForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(COTA04ContactsForm $COTA04ContactsForm)
    {

        if($COTA04ContactsForm->delete()){
            Session::flash('success', 'Formulário deletado com sucessso');
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

        if($deleted = COTA04ContactsForm::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' formulários deletados com sucessso']);
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
            COTA04ContactsForm::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
