<?php

namespace App\Http\Controllers\Abouts;

use App\Models\Abouts\ABOU02Abouts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Abouts\ABOU02AboutsBanner;

class ABOU02Controller extends Controller
{
    protected $path = 'uploads/Abouts/ABOU02/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = ABOU02Abouts::with('topics')->first();
        $banner = ABOU02AboutsBanner::first();
        return view('Admin.cruds.Abouts.ABOU02.edit', [
            'about' => $about,
            'banner' => $banner,
            'cropSetting' => getCropImage('Abouts', 'ABOU02')
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

        if(ABOU02Abouts::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Session::flash('success', 'Erro ao cadastradar as informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abouts\ABOU02Abouts  $ABOU02Abouts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU02Abouts $ABOU02Abouts)
    {
        $data = $request->all();

        if($ABOU02Abouts->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Session::flash('success', 'Erro ao atualizar as informações');
        }
        return redirect()->back();
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Abouts\ABOU02Abouts  $ABOU02Abouts
     * @return \Illuminate\Http\Response
     */
    //public function show(ABOU02Abouts $ABOU02Abouts)
    public function show()
    {
        //
        return view('Client.pages.Abouts.ABOU02.show');
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Abouts', 'ABOU02');

        return view('Client.pages.Abouts.ABOU02.page',[
            'sections' => $sections
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        return view('Client.pages.Abouts.ABOU02.section');
    }
}
