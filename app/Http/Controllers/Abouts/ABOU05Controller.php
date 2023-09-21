<?php

namespace App\Http\Controllers\Abouts;

use App\Models\Abouts\ABOU05Abouts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Abouts\ABOU05AboutsContent;
use App\Models\Abouts\ABOU05AboutsSection;

class ABOU05Controller extends Controller
{
    protected $path = 'uploads/Abouts/ABOU05/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = ABOU05Abouts::first();
        $section = ABOU05AboutsSection::first();
        $contents = ABOU05AboutsContent::sorting()->get();
        return view('Admin.cruds.Abouts.ABOU05.edit', [
            'about' => $about,
            'section' => $section,
            'contents' => $contents,
            'cropSetting' => getCropImage('Abouts', 'ABOU05')
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

        if(ABOU05Abouts::create($data)){
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
     * @param  \App\Models\Abouts\ABOU05Abouts  $ABOU05Abouts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU05Abouts $ABOU05Abouts)
    {
        $data = $request->all();

        if($ABOU05Abouts->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar as informações');
        }
        return redirect()->back();
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Abouts\ABOU05Abouts  $ABOU05Abouts
     * @return \Illuminate\Http\Response
     */
    //public function show(ABOU05Abouts $ABOU05Abouts)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Products', 'ABOU05', 'show');

        return view('Client.pages.Products.ABOU05.show',[
            'sections' => $sections
        ]);
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Abouts', 'ABOU05', 'page');

        return view('Client.pages.Abouts.ABOU05.page',[
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
        return view('Client.pages.Abouts.ABOU05.section');
    }
}
