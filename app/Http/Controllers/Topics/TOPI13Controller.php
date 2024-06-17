<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI13Topics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Topics\TOPI13TopicsSection;

class TOPI13Controller extends Controller
{
    protected $path = 'uploads/Topics/TOPI13/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI13Topics::sorting()->get();
        $section = TOPI13TopicsSection::sorting()->first();
        return view('Admin.cruds.Topics.TOPI13.index',[
            'topics' => $topics,
            'section' => $section
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Topics.TOPI13.create', [
            'cropSetting' => getCropImage('Topics', 'TOPI13')
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

        $data['active'] = $request->active ? 1 : 0;
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if(TOPI13Topics::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi13.index');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI13Topics  $TOPI13Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI13Topics $TOPI13Topics)
    {
        return view('Admin.cruds.Topics.TOPI13.edit', [
            'topic' => $TOPI13Topics,
            'cropSetting' => getCropImage('Topics', 'TOPI13')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI13Topics  $TOPI13Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI13Topics $TOPI13Topics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($TOPI13Topics, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($TOPI13Topics, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop){
            storageDelete($TOPI13Topics, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($TOPI13Topics, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile){
            storageDelete($TOPI13Topics, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($TOPI13Topics, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }


        if($TOPI13Topics->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI13Topics  $TOPI13Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI13Topics $TOPI13Topics)
    {
        storageDelete($TOPI13Topics, 'path_image_icon');
        storageDelete($TOPI13Topics, 'path_image_desktop');
        storageDelete($TOPI13Topics, 'path_image_mobile');

        if($TOPI13Topics->delete()){
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

        $TOPI13Topicss = TOPI13Topics::whereIn('id', $request->deleteAll)->get();
        foreach($TOPI13Topicss as $TOPI13Topics){
            storageDelete($TOPI13Topics, 'path_image_icon');
            storageDelete($TOPI13Topics, 'path_image_desktop');
            storageDelete($TOPI13Topics, 'path_image_mobile');
        }

        if($deleted = TOPI13Topics::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' tópicos deletados com sucessso']);
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
            TOPI13Topics::where('id', $id)->update(['sorting' => $sorting]);
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
        $topics = TOPI13Topics::active()->sorting()->get();
        $section = TOPI13TopicsSection::active()->sorting()->first();

        return view('Client.pages.Topics.TOPI13.section', [
            'topics' => $topics,
            'section' => $section
        ]);
    }
}
