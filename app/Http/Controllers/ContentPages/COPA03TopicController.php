<?php

namespace App\Http\Controllers\ContentPages;

use App\Models\ContentPages\COPA03ContentPagesTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class COPA03TopicController extends Controller
{
    protected $path = 'uploads/ContentPages/COPA03/images/';

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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->path);
        if($path_archive) $data['path_archive'] = $path_archive;

        if(COPA03ContentPagesTopic::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Storage::delete($path_archive);
            Session::flash('error', 'Erro ao cadastradar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentPages\COPA03ContentPagesTopic  $COPA03ContentPagesTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COPA03ContentPagesTopic $COPA03ContentPagesTopic)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($COPA03ContentPagesTopic, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($COPA03ContentPagesTopic, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($COPA03ContentPagesTopic, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($COPA03ContentPagesTopic, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->path);
        if($path_archive){
            storageDelete($COPA03ContentPagesTopic, 'path_archive');
            $data['path_archive'] = $path_archive;
        }
        if($request->delete_path_archive && !$path_archive){
            storageDelete($COPA03ContentPagesTopic, 'path_archive');
            $data['path_archive'] = null;
        }

        if($COPA03ContentPagesTopic->fill($data)->save()){
            Session::flash('success', 'Tópico atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Storage::delete($path_archive);
            Session::flash('error', 'Erro ao atualizar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentPages\COPA03ContentPagesTopic  $COPA03ContentPagesTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(COPA03ContentPagesTopic $COPA03ContentPagesTopic)
    {
        storageDelete($COPA03ContentPagesTopic, 'path_image');
        storageDelete($COPA03ContentPagesTopic, 'path_image_icon');
        storageDelete($COPA03ContentPagesTopic, 'path_archive');

        if($COPA03ContentPagesTopic->delete()){
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

        $COPA03ContentPagesTopics = COPA03ContentPagesTopic::whereIn('id', $request->deleteAll)->get();
        foreach($COPA03ContentPagesTopics as $COPA03ContentPagesTopic){
            storageDelete($COPA03ContentPagesTopic, 'path_image');
            storageDelete($COPA03ContentPagesTopic, 'path_image_icon');
            storageDelete($COPA03ContentPagesTopic, 'path_archive');
        }

        if($deleted = COPA03ContentPagesTopic::whereIn('id', $request->deleteAll)->delete()){
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
            COPA03ContentPagesTopic::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
