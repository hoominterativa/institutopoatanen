<?php

namespace App\Http\Controllers\Slides;

use App\Models\Slides\SLID02Slides;
use App\Models\Slides\SLID02SlidesTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;


class SLID02Controller extends Controller
{
    protected  $path = 'uploads/Slides/SLID02/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slides = SLID02Slides::sorting()->get();
        $topics = SLID02SlidesTopic::sorting()->get();
        return view('Admin.cruds.Slides.SLID02.index',[
            'slides' => $slides, 
            'topics' => $topics
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Slides.SLID02.create',[
            'cropSetting' => getCropImage('Slides', 'SLID02')
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

        
        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        $data['active'] = $request->active?1:0;
        $data['active_mobile'] = $request->active_mobile?1:0;

        if($request->external_link_button){
            $data['link_button'] = $request->link_button;
            $data['target_link_button'] = '_self';
        }

        if(SLID02Slides::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.slid02.index');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slides\SLID02Slides  $SLID02Slides
     * @return \Illuminate\Http\Response
     */
    public function edit(SLID02Slides $SLID02Slides)
    {
        $SLID02Slides->link = getUri($SLID02Slides->link);
        return view('Admin.cruds.Slides.SLID02.edit',[
            'slide' => $SLID02Slides,
            'cropSetting' => getCropImage('Slides', 'SLID02')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slides\SLID02Slides  $SLID02Slides
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SLID02Slides $SLID02Slides)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if($path_image_desktop){
            storageDelete($SLID02Slides, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($SLID02Slides, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if($path_image_mobile){
            storageDelete($SLID02Slides, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($SLID02Slides, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        $data['active'] = $request->active?1:0;
        $data['active_mobile'] = $request->active_mobile?1:0;
        $data['link_button'] = getUri($request->link_button);

        if($SLID02Slides->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.slid02.index');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slides\SLID02Slides  $SLID02Slides
     * @return \Illuminate\Http\Response
     */
    public function destroy(SLID02Slides $SLID02Slides)
    {
        storageDelete($SLID02Slides, 'path_image_desktop');
        storageDelete($SLID02Slides, 'path_image_mobile');

        if($SLID02Slides->delete()){
            Session::flash('success', 'Item deletado com sucessso');
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

        $SLID02Slidess = SLID02Slides::whereIn('id', $request->deleteAll)->get();
        foreach($SLID02Slidess as $SLID02Slides){
            storageDelete($SLID02Slides, 'path_image_desktop');
            storageDelete($SLID02Slides, 'path_image_mobile');
        }


        if($deleted = SLID02Slides::whereIn('id', $request->deleteAll)->delete()){
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
            SLID02Slides::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

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
                $slides = SLID02Slides::where('path_image_mobile','!=','')->activeMobile()->sorting()->get();
                foreach($slides as $slide){
                    $slide->link = $slide->link_mobile;
                    $slide->target_link = $slide->target_link;
                    $slide->path_image_desktop = $slide->path_image_mobile;
                    $slide->active = $slide->active_mobile;
                }
            break;
            default:
                $slides = SLID02Slides::where('path_image_desktop','!=','')->active()->sorting()->get();
            break;
        }

        $topics = SLID02SlidesTopic::active()->sorting()->get();

        return view('Client.pages.Slides.SLID02.section', [
            'slides' => $slides,
            'topics' => $topics
        ]);
    }
}
