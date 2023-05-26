<?php

namespace App\Http\Controllers\Abouts;

use App\Models\Abouts\ABOU01Abouts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class ABOU01Controller extends Controller
{
    protected $path = 'uploads/Abouts/ABOU01/images/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = ABOU01Abouts::with('topics')->first();
        return view('Admin.cruds.Abouts.ABOU01.edit',[
            'about' => $about,
            'cropSetting' => getCropImage('Abouts', 'ABOU01')
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

        $path_image_banner = $helper->optimizeImage($request, 'path_image_banner', $this->path, null, 100);
        if($path_image_banner) $data['path_image_banner'] = $path_image_banner;

        $path_image_inner_section = $helper->optimizeImage($request, 'path_image_inner_section', $this->path, null, 100);
        if($path_image_inner_section) $data['path_image_inner_section'] = $path_image_inner_section;

        if(ABOU01Abouts::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Storage::delete($path_image_banner);
            Storage::delete($path_image_inner_section);
            Session::flash('success', 'Erro ao cadastradar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abouts\ABOU01Abouts  $ABOU01Abouts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU01Abouts $ABOU01Abouts)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        // path_image_banner
        $path_image_banner = $helper->optimizeImage($request, 'path_image_banner', $this->path, null, 100);
        if($path_image_banner){
            storageDelete($ABOU01Abouts, 'path_image_banner');
            $data['path_image_banner'] = $path_image_banner;
        }
        if($request->delete_path_image_banner && !$path_image_banner){
            storageDelete($ABOU01Abouts, 'path_image_banner');
            $data['path_image_banner'] = null;
        }

        // path_image_inner_section
        $path_image_inner_section = $helper->optimizeImage($request, 'path_image_inner_section', $this->path, null, 100);
        if($path_image_inner_section){
            storageDelete($ABOU01Abouts, 'path_image_inner_section');
            $data['path_image_inner_section'] = $path_image_inner_section;
        }
        if($request->delete_path_image_inner_section && !$path_image_inner_section){
            storageDelete($ABOU01Abouts, 'path_image_inner_section');
            $data['path_image_inner_section'] = null;
        }

        if($ABOU01Abouts->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image_banner);
            Storage::delete($path_image_inner_section);
            Session::flash('success', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    // METHODS CLIENT

     /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Abouts', 'ABOU01');

        $about = ABOU01Abouts::with('topics')->first();

        return view('Client.pages.Abouts.ABOU01.page',[
            'about' => $about,
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
        $about = ABOU01Abouts::with('topics')->first();
        return view('Client.pages.Abouts.ABOU01.section',[
            'about' => $about
        ]);
    }
}
