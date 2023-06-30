<?php

namespace App\Http\Controllers\Slides;

use App\Models\Slides\SLID03SlidesForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;

class SLID03FormController extends Controller
{
    protected $path = 'uploads/Slides/SLID03/images/';

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

        $path_image_lightbox = $helper->optimizeImage($request, 'path_image_lightbox', $this->path, null,100);
        if($path_image_lightbox) $data['path_image_lightbox'] = $path_image_lightbox;

        $data['active'] = $request->active?1:0;

        if(SLID03SlidesForm::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Storage::delete($path_image_lightbox);
            Session::flash('error', 'Erro ao cadastradar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slides\SLID03SlidesForm  $SLID03SlidesForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SLID03SlidesForm $SLID03SlidesForm)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_lightbox = $helper->optimizeImage($request, 'path_image_lightbox', $this->path, null,100);
        if($path_image_lightbox){
            storageDelete($SLID03SlidesForm, 'path_image_lightbox');
            $data['path_image_lightbox'] = $path_image_lightbox;
        }
        if($request->delete_path_image_lightbox && !$path_image_lightbox){
            storageDelete($SLID03SlidesForm, 'path_image_lightbox');
            $data['path_image_lightbox'] = null;
        }

        $data['active'] = $request->active?1:0;

        if($SLID03SlidesForm->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image_lightbox);
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function inputStore(Request $request)
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
                        'required' => $required,
                    ]
                ];
                $arrayInputs = array_merge($arrayInputs, $pushArray);
            }
        }
        $jsonInputs = json_encode($arrayInputs);

        $data['inputs'] = $jsonInputs;

        if(SLID03SlidesForm::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slides\SLID03SlidesForm  $SLID03SlidesForm
     * @return \Illuminate\Http\Response
     */
    public function inputUpdate(Request $request, SLID03SlidesForm $SLID03SlidesForm)
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
                        'required' => $required,
                    ]
                ];
                $arrayInputs = array_merge($arrayInputs, $pushArray);
            }
        }

        if(count($arrayInputs)){
            $jsonInputs = json_encode($arrayInputs);
            $data['inputs'] = $jsonInputs;
        }

        if($SLID03SlidesForm->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function additionalStore(Request $request)
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
                        'required' => $required,
                    ]
                ];
                $arrayInputs = array_merge($arrayInputs, $pushArray);
            }
        }
        $jsonInputs = json_encode($arrayInputs);

        $data['inputs_additionals'] = $jsonInputs;

        if(SLID03SlidesForm::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Session::flash('error', 'Erro ao cadastradar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slides\SLID03SlidesForm  $SLID03SlidesForm
     * @return \Illuminate\Http\Response
     */
    public function additionalUpdate(Request $request, SLID03SlidesForm $SLID03SlidesForm)
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
                        'required' => $required,
                    ]
                ];
                $arrayInputs = array_merge($arrayInputs, $pushArray);
            }
        }

        if(count($arrayInputs)){
            $jsonInputs = json_encode($arrayInputs);
            $data['inputs_additionals'] = $jsonInputs;
        }

        if($SLID03SlidesForm->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }
}
