<?php

namespace App\Http\Controllers\Topics;

use Illuminate\Http\Request;
use App\Models\Topics\TOPI02Topics;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Topics\TOPI02TopicsSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TOPI02Controller extends Controller
{
    protected $path = 'uploads/Topics/TOPI02/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI02Topics::sorting()->get();
        $section = TOPI02TopicsSection::first();

        return view('Admin.cruds.Topics.TOPI02.index',[
            'topics' => $topics,
            'section' => $section,
            'cropSetting' => getCropImage('Topics', 'TOPI02')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Topics.TOPI02.create',[
            'cropSetting' => getCropImage('Topics', 'TOPI02')
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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image'] = $path_image_icon;

        $data['active'] = $request->active?1:0;
        $data['link'] = getUri($request->link);

        if(TOPI02Topics::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi02.index');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao cadastradar tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI02Topics  $TOPI02Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI02Topics $TOPI02Topics)
    {
        $TOPI02Topics->link = getUri($TOPI02Topics->link);
        return view('Admin.cruds.Topics.TOPI02.edit',[
            'topic' => $TOPI02Topics,
            'cropSetting' => getCropImage('Topics', 'TOPI02')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI02Topics  $TOPI02Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI02Topics $TOPI02Topics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($TOPI02Topics, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($TOPI02Topics, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($TOPI02Topics, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($TOPI02Topics, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $data['active'] = $request->active?1:0;
        $data['link'] = getUri($request->link);

        if($TOPI02Topics->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
            return redirect()->route('admin.topi02.index');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao atualizar informações');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI02Topics  $TOPI02Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI02Topics $TOPI02Topics)
    {
        storageDelete($TOPI02Topics, 'path_image');
        storageDelete($TOPI02Topics, 'path_image_icon');

        if($TOPI02Topics->delete()){
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
        $TOPI02Topicss = TOPI02Topics::whereIn('id', $request->deleteAll)->get();
        foreach($TOPI02Topicss as $TOPI02Topics){
            storageDelete($TOPI02Topics, 'path_image');
            storageDelete($TOPI02Topics, 'path_image_icon');
        }

        if($deleted = TOPI02Topics::whereIn('id', $request->deleteAll)->delete()){
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
            TOPI02Topics::where('id', $id)->update(['sorting' => $sorting]);
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
        $topics = TOPI02Topics::active()->sorting()->get();
        $section = TOPI02TopicsSection::active()->first();
        return view('Client.pages.Topics.TOPI02.section',[
            'topics' => $topics,
            'section' => $section,
        ]);
    }
}
