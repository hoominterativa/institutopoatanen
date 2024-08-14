<?php

namespace App\Http\Controllers\Slides;

use App\Models\Slides\SLID01Slides;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;

class SLID01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slides = SLID01Slides::sorting()->get();
        return view('Admin.cruds.Slides.SLID01.index',[
            'slides' => $slides
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Slides.SLID01.create',[
            'cropSetting' => getCropImage('Slides', 'SLID01')
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

        $path = 'uploads/Slides/SLID01/images/';
        $helper = new HelperArchive();

        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        $path_image = $helper->optimizeImage($request, 'path_image', $path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $data['active'] = $request->active?1:0;

        if(SLID01Slides::create($data)){
            Session::flash('success', 'Banner cadastrado com sucesso');
            return redirect()->route('admin.slid01.index');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Storage::delete($path_image);
            Session::flash('success', 'Erro ao cadastradar o banner');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slides\SLID01Slides  $SLID01Slides
     * @return \Illuminate\Http\Response
     */
    public function edit(SLID01Slides $SLID01Slides)
    {

        return view('Admin.cruds.Slides.SLID01.edit',[
            'slide' => $SLID01Slides,
            'cropSetting' => getCropImage('Slides', 'SLID01')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slides\SLID01Slides  $SLID01Slides
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SLID01Slides $SLID01Slides)
    {
        $data = $request->all();

        $path = 'uploads/Slides/SLID01/images/';
        $helper = new HelperArchive();

        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        // IMAGE DESKTOP
        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $path, null,100);
        if($path_image_desktop){
            storageDelete($SLID01Slides, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($SLID01Slides, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        // IMAGE MOBILE
        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $path, null,100);
        if($path_image_mobile){
            storageDelete($SLID01Slides, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($SLID01Slides, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        // IMAGE PNG
        $path_image = $helper->optimizeImage($request, 'path_image', $path, null,100);
        if($path_image){
            storageDelete($SLID01Slides, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SLID01Slides, 'path_image');
            $data['path_image'] = null;
        }

        $data['active'] = $request->active?1:0;

        if($SLID01Slides->fill($data)->save()){
            Session::flash('success', 'Banner atualizado com sucesso');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Storage::delete($path_image);
            Session::flash('success', 'Erro ao atualizar banner');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slides\SLID01Slides  $SLID01Slides
     * @return \Illuminate\Http\Response
     */
    public function destroy(SLID01Slides $SLID01Slides)
    {
        storageDelete($SLID01Slides, 'path_image_desktop');
        storageDelete($SLID01Slides, 'path_image_mobile');
        storageDelete($SLID01Slides, 'path_image');

        if($SLID01Slides->delete()){
            Session::flash('success', 'Banner deletado com sucessso');
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
        $SLID01Slidess = SLID01Slides::whereIn('id', $request->deleteAll)->get();
        foreach($SLID01Slidess as $SLID01Slides){
            Storage::delete($SLID01Slides->path_image_desktop);
            Storage::delete($SLID01Slides->path_image_mobile);
            Storage::delete($SLID01Slides->path_image);
        }

        if($deleted = SLID01Slides::whereIn('id', $request->deleteAll)->delete()){
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
            SLID01Slides::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $slides = SLID01Slides::active()->sorting()->get();

        return view('Client.pages.Slides.SLID01.section',[
            'slides' => $slides
        ]);
    }
}
