<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\SettingSmtp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SettingSmtpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settingSmtp = SettingSmtp::first();
        return view('Admin.cruds.settingSMTP.edit',[
            'settingSmtp' => $settingSmtp
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SettingSmtp  $SettingSmtp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SettingSmtp $SettingSmtp)
    {
        $data = $request->all();
        if($SettingSmtp->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    /**
     * verify connection smtp.
     *
     * @return json
     */
    public function smtpVerify()
    {
        try {
            $setting = SettingSmtp::first();
            Mail::raw('Esse é um teste automático de e-mail para verificar a conexão do seu site com o SMTP.', function($msg) use ($setting) {
                $msg->to('anderson@hoom.com.br')->subject('Teste E-mail')->from($setting->user);
            });
            return Response::json(['status'=> 'success', 'message' => 'Teste de SMTP realizado com sucesso']);
        } catch (Exception $e) {
            return Response::json([
                'status'=> 'error',
                'message' => 'Não foi possível realizar o teste, verifique se todas as informações estão corretas',
                'details' => $e->getMessage()
            ]);
        }
    }
}
