<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV12ServicesTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Services\SERV12ServicesTopicGallery;

class SERV12TopicController extends Controller
{
    protected $path = 'uploads/Services/SERV12/images/';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Services.SERV12.Topics.create',[
            'cropSetting' => getCropImage('Services', 'SERV12'),
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

        if($topic = SERV12ServicesTopic::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.serv12.topic.edit', ['SERV12ServicesTopic' => $topic->id]);
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV12ServicesTopic  $SERV12ServicesTopic
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV12ServicesTopic $SERV12ServicesTopic)
    {
        $topicGalleries = SERV12ServicesTopicGallery::where('topic_id', $SERV12ServicesTopic->id)->sorting()->get();
        return view('Admin.cruds.Services.SERV12.Topics.edit',[
            'cropSetting' => getCropImage('Services', 'SERV12'),
            'topic' => $SERV12ServicesTopic,
            'topicGalleries' => $topicGalleries
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV12ServicesTopic  $SERV12ServicesTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV12ServicesTopic $SERV12ServicesTopic)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($SERV12ServicesTopic, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($SERV12ServicesTopic, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($SERV12ServicesTopic->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV12ServicesTopic  $SERV12ServicesTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV12ServicesTopic $SERV12ServicesTopic)
    {
        storageDelete($SERV12ServicesTopic, 'path_image');

        if($SERV12ServicesTopic->delete()){
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

        $SERV12ServicesTopics = SERV12ServicesTopic::whereIn('id', $request->deleteAll)->get();
        foreach($SERV12ServicesTopics as $SERV12ServicesTopic){
            storageDelete($SERV12ServicesTopic, 'path_image_icon');
        }

        if($deleted = SERV12ServicesTopic::whereIn('id', $request->deleteAll)->delete()){
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
            SERV12ServicesTopic::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
