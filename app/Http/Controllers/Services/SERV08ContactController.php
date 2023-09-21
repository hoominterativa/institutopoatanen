<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV08ServicesContact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV08ContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        if(SERV08ServicesContact::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar as informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV08ServicesContact  $SERV08ServicesContact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV08ServicesContact $SERV08ServicesContact)
    {
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

        if($SERV08ServicesContact->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar as informações');
        }
        return redirect()->back();
    }
}
