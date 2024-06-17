<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI12Topics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Topics\TOPI12TopicsSection;

class TOPI12Controller extends Controller
{
    protected $path = 'uploads/Topics/TOPI12/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI12Topics::sorting()->get();
        $section = TOPI12TopicsSection::sorting()->first();
        return view('Admin.cruds.Topics.TOPI12.index', [
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
        return view('Admin.cruds.Topics.TOPI12.create', [
            'cropSetting' => getCropImage('Topics', 'TOPI12')
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

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(TOPI12Topics::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi12.index');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI12Topics  $TOPI12Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI12Topics $TOPI12Topics)
    {
        return view('Admin.cruds.Topics.TOPI12.edit', [
            'topic' => $TOPI12Topics,
            'cropSetting' => getCropImage('Topics', 'TOPI12')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI12Topics  $TOPI12Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI12Topics $TOPI12Topics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($TOPI12Topics, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($TOPI12Topics, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($TOPI12Topics->fill($data)->save()){
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
     * @param  \App\Models\Topics\TOPI12Topics  $TOPI12Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI12Topics $TOPI12Topics)
    {
        storageDelete($TOPI12Topics, 'path_image_icon');

        if($TOPI12Topics->delete()){
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

        $TOPI12Topicss = TOPI12Topics::whereIn('id', $request->deleteAll)->get();
        foreach($TOPI12Topicss as $TOPI12Topics){
            storageDelete($TOPI12Topics, 'path_image_icon');
        }

        if($deleted = TOPI12Topics::whereIn('id', $request->deleteAll)->delete()){
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
            TOPI12Topics::where('id', $id)->update(['sorting' => $sorting]);
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
        $topics = TOPI12Topics::active()->sorting()->get();
        $section = TOPI12TopicsSection::active()->sorting()->first();
        return view('Client.pages.Topics.TOPI12.section', [
            'topics' => $topics,
            'section' => $section
        ]);
    }
}
