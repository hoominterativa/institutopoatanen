<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT09ContentsTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class CONT09TopicController extends Controller
{
    protected $path = 'uploads/Contents/CONT09/images/';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Contents.CONT09.Topics.create', [
            'cropSetting' => getCropImage('Contents', 'CONT09')
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

        $data['active'] = $request->active?1:0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(CONT09ContentsTopic::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.cont09.index');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contents\CONT09ContentsTopic  $CONT09ContentsTopic
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT09ContentsTopic $CONT09ContentsTopic)
    {
        return view('Admin.cruds.Contents.CONT09.Topics.edit', [
            'topic' => $CONT09ContentsTopic,
            'cropSetting' => getCropImage('Contents', 'CONT09')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT09ContentsTopic  $CONT09ContentsTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT09ContentsTopic $CONT09ContentsTopic)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($CONT09ContentsTopic, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($CONT09ContentsTopic, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($CONT09ContentsTopic->fill($data)->save()){
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
     * @param  \App\Models\Contents\CONT09ContentsTopic  $CONT09ContentsTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT09ContentsTopic $CONT09ContentsTopic)
    {
        storageDelete($CONT09ContentsTopic, 'path_image_icon');

        if($CONT09ContentsTopic->delete()){
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

        $CONT09ContentsTopics = CONT09ContentsTopic::whereIn('id', $request->deleteAll)->get();
        foreach($CONT09ContentsTopics as $CONT09ContentsTopic){
            storageDelete($CONT09ContentsTopic, 'path_image_icon');
        }

        if($deleted = CONT09ContentsTopic::whereIn('id', $request->deleteAll)->delete()){
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
            CONT09ContentsTopic::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
