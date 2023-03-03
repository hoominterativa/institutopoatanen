<?php

namespace App\Http\Controllers\Slides;

use App\Models\Slides\SLID02SlidesTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SLID02TopicController extends Controller
{
    protected  $path = 'uploads/Slides/SLID02/images/';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        return view('Admin.cruds.Slides.SLID02.Topics.create', [
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

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_image_icon_mobile = $helper->optimizeImage($request, 'path_image_icon_mobile', $this->path, null,100);
        if($path_image_icon_mobile) $data['path_image_icon_mobile'] = $path_image_icon_mobile;

        if(SLID02SlidesTopic::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.slid02.index');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image_icon_mobile);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slides\SLID02SlidesTopic  $SLID02SlidesTopic
     * @return \Illuminate\Http\Response
     */
    public function edit(SLID02SlidesTopic $SLID02SlidesTopic)
    {
        $SLID02SlidesTopic->link = getUri($SLID02SlidesTopic->link);
        return view('Admin.cruds.Slides.SLID02.Topics.edit',[
            'topic' => $SLID02SlidesTopic,
            'cropSetting' => getCropImage('Slides', 'SLID02')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slides\SLID02SlidesTopic  $SLID02SlidesTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SLID02SlidesTopic $SLID02SlidesTopic)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $path, null,100);
        if($path_image_icon){
            storageDelete($SLID02SlidesTopic, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($SLID02SlidesTopic, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_image_icon_mobile = $helper->optimizeImage($request, 'path_image_icon_mobile', $path, null,100);
        if($path_image_icon_mobile){
            storageDelete($SLID02SlidesTopic, 'path_image_icon_mobile');
            $data['path_image_icon_mobile'] = $path_image_icon_mobile;
        }
        if($request->delete_path_image_icon_mobile && !$path_image_icon_mobile){
            storageDelete($SLID02SlidesTopic, 'path_image_icon_mobile');
            $data['path_image_icon_mobile'] = null;
        }

        if($SLID02SlidesTopic->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.slid02.index');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image_icon_mobile);
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slides\SLID02SlidesTopic  $SLID02SlidesTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(SLID02SlidesTopic $SLID02SlidesTopic)
    {
        storageDelete($SLID02SlidesTopic, 'path_image_icon');
        storageDelete($SLID02SlidesTopic, 'path_image_icon_mobile');

        if($SLID02SlidesTopic->delete()){
            Session::flash('success', 'Tópico deletado com sucessso');
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

        $SLID02SlidesTopics = SLID02SlidesTopic::whereIn('id', $request->deleteAll)->get();
        foreach($SLID02SlidesTopics as $SLID02SlidesTopic){
            storageDelete($SLID02SlidesTopic, 'path_image_icon');
            storageDelete($SLID02SlidesTopic, 'path_image_icon_mobile');
        }

        if($deleted = SLID02SlidesTopic::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Tópicos deletados com sucessso']);
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
            SLID02SlidesTopic::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
