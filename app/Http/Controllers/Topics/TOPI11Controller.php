<?php

namespace App\Http\Controllers\Topics;

use Illuminate\Http\Request;
use App\Models\Topics\TOPI11Topics;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Topics\TOPI11TopicsImage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Topics\TOPI11TopicsSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TOPI11Controller extends Controller
{
    protected $path = 'uploads/Topics/TOPI11/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI11Topics::sorting()->get();
        $section = TOPI11TopicsSection::first();
        $image = TOPI11TopicsImage::first();

        return view('Admin.cruds.Topics.TOPI11.index', [
            'topics' => $topics,
            'section' => $section,
            'image' => $image,
            'cropSetting' => getCropImage('Topics', 'TOPI11')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Topics.TOPI11.create', ['cropSetting' => getCropImage('Topics', 'TOPI11')]);
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

        $data['active'] = $request->active? 1 : 0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(TOPI11Topics::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi11.index');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI11Topics  $TOPI11Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI11Topics $TOPI11Topics)
    {

        return view('Admin.cruds.Topics.TOPI11.edit',[
            'topic' => $TOPI11Topics,
            'cropSetting' => getCropImage('Topics', 'TOPI11')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI11Topics  $TOPI11Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI11Topics $TOPI11Topics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active? 1 : 0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($TOPI11Topics, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($TOPI11Topics, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($TOPI11Topics->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI11Topics  $TOPI11Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI11Topics $TOPI11Topics)
    {
        storageDelete($TOPI11Topics, 'path_image_icon');

        if($TOPI11Topics->delete()){
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
        $TOPI11Topicss = TOPI11Topics::whereIn('id', $request->deleteAll)->get();
        foreach($TOPI11Topicss as $TOPI11Topics){
            storageDelete($TOPI11Topics, 'path_image_icon');
        }

        if($deleted = TOPI11Topics::whereIn('id', $request->deleteAll)->delete()){
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
            TOPI11Topics::where('id', $id)->update(['sorting' => $sorting]);
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
        $topics = TOPI11Topics::active()->sorting()->get();
        $section = TOPI11TopicsSection::active()->first();
        $image = TOPI11TopicsImage::active()->first();
        return view('Client.pages.Topics.TOPI11.section',[
            'topics' => $topics,
            'section' => $section,
            'image' => $image
        ]);
    }
}
