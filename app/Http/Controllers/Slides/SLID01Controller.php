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

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        $path_image_png = $helper->optimizeImage($request, 'path_image_png', $path, null,100);
        if($path_image_png) $data['path_image_png'] = $path_image_png;

        $data['active'] = $request->active?1:0;
        $data['active_mobile'] = $request->active_mobile?1:0;

        if($request->external_link_button){
            $data['link_button'] = $request->link_button;
            $data['target_link_button'] = '_self';
        }

        if(SLID01Slides::create($data)){
            Session::flash('success', 'Banner cadastrado com sucesso');
            return redirect()->route('admin.slid01.index');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Storage::delete($path_image_png);
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
        if($SLID01Slides->link_button) $SLID01Slides->link_button = url(getUri($SLID01Slides->link_button));
        if($SLID01Slides->link_button_mobile) $SLID01Slides->link_button_mobile = url(getUri($SLID01Slides->link_button_mobile));

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
        $path_image_png = $helper->optimizeImage($request, 'path_image_png', $path, null,100);
        if($path_image_png){
            storageDelete($SLID01Slides, 'path_image_png');
            $data['path_image_png'] = $path_image_png;
        }
        if($request->delete_path_image_png && !$path_image_png){
            storageDelete($SLID01Slides, 'path_image_png');
            $data['path_image_png'] = null;
        }

        $data['active'] = $request->active?1:0;
        $data['active_mobile'] = $request->active_mobile?1:0;
        $data['link_button'] = getUri($request->link_button);

        if($SLID01Slides->fill($data)->save()){
            Session::flash('success', 'Banner atualizado com sucesso');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Storage::delete($path_image_png);
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
        storageDelete($SLID01Slides, 'path_image_png');

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
            Storage::delete($SLID01Slides->path_image_png);
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
        switch(deviceDetect()){
            case 'mobile':
            case 'tablet':
                $slides = SLID01Slides::where('path_image_mobile','!=','')->activeMobile()->sorting()->get();
                foreach($slides as $slide){
                    $slide->title = $slide->title_mobile;
                    $slide->subtitle = $slide->subtitle_mobile;
                    $slide->description = $slide->description_mobile;
                    $slide->title_button = $slide->title_button_mobile;
                    $slide->link_button = $slide->link_button_mobile;
                    $slide->path_image_desktop = $slide->path_image_mobile;
                    $slide->path_image_png = null;
                    $slide->active = $slide->active_mobile;
                }
            break;
            default:
                $slides = SLID01Slides::where('path_image_desktop','!=','')->active()->sorting()->get();
            break;
        }

        return view('Client.pages.Slides.SLID01.section',[
            'slides' => $slides
        ]);
    }
}
