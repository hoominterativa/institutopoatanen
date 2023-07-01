<?php

namespace App\Http\Controllers\Slides;


use Exception;
use App\Models\ContactLead;
use App\Mail\ContactLead as ContactLeadMail;
use Illuminate\Http\Request;
use App\Models\Slides\SLID03Slides;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactLeadConfirmation;
use App\Models\Slides\SLID03SlidesForm;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SLID03Controller extends Controller
{
    protected $path = 'uploads/Slides/SLID03/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slide = SLID03Slides::first();
        $form = SLID03SlidesForm::first();
        $inputs = json_decode($form->inputs);
        $inputsAdditionals = json_decode($form->inputs_additionals);
        $compliances = getCompliance(null, 'id', 'title_page');

        return view('Admin.cruds.Slides.SLID03.index',[
            'slide' => $slide,
            'form' => $form,
            'inputs' => !is_array($inputs)?$inputs:null,
            'inputsAdditionals' => !is_array($inputsAdditionals)?$inputsAdditionals:null,
            'compliances' => $compliances,
            'cropSetting' => getCropImage('Slides', 'SLID03'),
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

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        $data['active'] = $request->active?1:0;

        if(SLID03Slides::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar informações');
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slides\SLID03Slides  $SLID03Slides
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SLID03Slides $SLID03Slides)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop){
            storageDelete($SLID03Slides, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($SLID03Slides, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile){
            storageDelete($SLID03Slides, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($SLID03Slides, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        $data['active'] = $request->active?1:0;

        if($SLID03Slides->fill($data)->save()){
            Session::flash('success', 'Informações atualizado com sucesso');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    public function additionals()
    {
        $form = SLID03SlidesForm::first();
        $inputsAdditionals = json_decode($form->inputs_additionals);
        return view('Client.pages.Slides.SLID03.additionals',[
            'inputsAdditionals' => !is_array($inputsAdditionals)?$inputsAdditionals:null,
        ]);
    }

    public function leads(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);

        $arrayInsert = [];
        $arrayInsertAddtionals = [];
        $newEmailRecipient = null;
        foreach ($data as $key => $value) {
            $array = explode('_', $key);
            $requestFile = null;
            if(COUNT($array) >= 3 ){
                $type = end($array);
                $name = str_replace('_'.$type, '', $key);
                switch ($type) {
                    case 'file':
                        $helperArchive = new HelperArchive();
                        $nameFile = $helperArchive->uploadArchive($request, $key, 'uploads/leads/archives/');
                        $value = $nameFile;
                        $requestFile = $request->file($key);
                    break;
                    case 'selectEmail':
                        $infoValue = explode('|',$value);
                        $value = $infoValue[0];
                        $newEmailRecipient = $infoValue[1];
                    break;
                }

                if(!is_array($value)){
                    $arrayInsert = array_merge($arrayInsert, [$data[$name] => ['value' => $value, 'type' => $type, 'requestFile' => $requestFile]]);
                }else{
                    $arrayInsertAddtionals = array_merge($arrayInsertAddtionals, [$data[$name][0] => ['value' => $value, 'type' => $type, 'requestFile' => $requestFile]]);
                }
            }
        }

        $additionals = [];
        foreach ($arrayInsertAddtionals as $name => $values) {
            foreach ($values['value'] as $key => $value) {
                if(isset($additionals['additional_'.$key])){
                    $additionals['additional_'.$key] = array_merge($additionals['additional_'.$key], [$name => $value]);
                }else{
                    $additionals = array_merge($additionals, ['additional_'.$key => [$name => $value]]);
                }
            }
        }

        if(COUNT($additionals)){
            $arrayInsert = array_merge($arrayInsert, ['additionals' => $additionals]);
        }

        if($request->has('target_send')){
            $emailRecipient = base64_decode($request->target_send);
        }

        if($newEmailRecipient){
            $emailRecipient = $newEmailRecipient;
        }

        // $contactLead = ContactLead::first();
        // return new ContactLeadMail($arrayInsert, $emailRecipient, $contactLead);

        $contactLead = ContactLead::create(['json' => json_encode($arrayInsert), 'target_lead' => $data['target_lead'], 'status_process' => 'upcoming']);

        try {
            Mail::send(new ContactLeadMail($arrayInsert, $emailRecipient, $contactLead));
            Mail::send(new ContactLeadConfirmation($contactLead));
        } catch (Exception $e) {
            dd($e->getMessage());
        }

        return Response::json([
            'status' => 'success',
            'redirect' => route('lead.confirmation')
        ]);
    }

    // METHODS CLIENT

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $slide = SLID03Slides::first();
        $form = SLID03SlidesForm::first();
        $inputs = json_decode($form->inputs);
        $inputsAdditionals = json_decode($form->inputs_additionals);

        return view('Client.pages.Slides.SLID03.section',[
            'slide' => $slide,
            'form' => $form,
            'inputs' => !is_array($inputs)?$inputs:null,
            'inputsAdditionals' => !is_array($inputsAdditionals)?$inputsAdditionals:null,
        ]);
    }
}
