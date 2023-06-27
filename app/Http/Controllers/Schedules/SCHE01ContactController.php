<?php

namespace App\Http\Controllers\Schedules;

use App\Models\Schedules\SCHE01SchedulesContact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SCHE01ContactController extends Controller
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

        if(SCHE01SchedulesContact::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar o item');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedules\SCHE01SchedulesContact  $SCHE01SchedulesContact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SCHE01SchedulesContact $SCHE01SchedulesContact)
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

        if($SCHE01SchedulesContact->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }
}
