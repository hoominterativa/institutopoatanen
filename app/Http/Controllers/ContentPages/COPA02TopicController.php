<?php

namespace App\Http\Controllers\ContentPages;

use App\Models\ContentPages\COPA02ContentPagesTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COPA02TopicController extends Controller
{
    protected $path = 'uploads/ContentPages/COPA02/images/';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA02.Topics.create', [
            'cropSetting' => getCropImage('ContentPages', 'COPA02')
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

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;

        if(COPA02ContentPagesTopic::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.copa02.index');
        }else{
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao cadastradar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContentPages\COPA02ContentPagesTopic  $COPA02ContentPagesTopic
     * @return \Illuminate\Http\Response
     */
    public function edit(COPA02ContentPagesTopic $COPA02ContentPagesTopic)
    {
        return view('Admin.cruds.ContentPages.COPA02.Topics.edit', [
            'topic' => $COPA02ContentPagesTopic,
            'cropSetting' => getCropImage('ContentPages', 'COPA02')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentPages\COPA02ContentPagesTopic  $COPA02ContentPagesTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COPA02ContentPagesTopic $COPA02ContentPagesTopic)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box){
            storageDelete($COPA02ContentPagesTopic, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($COPA02ContentPagesTopic, 'path_image_box');
            $data['path_image_box'] = null;
        }

        if($COPA02ContentPagesTopic->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao atualizar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentPages\COPA02ContentPagesTopic  $COPA02ContentPagesTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(COPA02ContentPagesTopic $COPA02ContentPagesTopic)
    {
        storageDelete($COPA02ContentPagesTopic, 'path_image_box');

        if($COPA02ContentPagesTopic->delete()){
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

        $COPA02ContentPagesTopics = COPA02ContentPagesTopic::whereIn('id', $request->deleteAll)->get();
        foreach($COPA02ContentPagesTopics as $COPA02ContentPagesTopic){
            storageDelete($COPA02ContentPagesTopic, 'path_image_box');
        }

        if($deleted = COPA02ContentPagesTopic::whereIn('id', $request->deleteAll)->delete()){
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
            COPA02ContentPagesTopic::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
