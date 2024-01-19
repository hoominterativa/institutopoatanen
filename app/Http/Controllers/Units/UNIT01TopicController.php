<?php

namespace App\Http\Controllers\Units;

use App\Models\Units\UNIT01UnitsTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class UNIT01TopicController extends Controller
{
    protected $path = 'uploads/Units/UNIT01/images/';

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
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(UNIT01UnitsTopic::create($data)){
            Session::flash('success', 'Tópico cadastrado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Units\UNIT01UnitsTopic  $UNIT01UnitsTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UNIT01UnitsTopic $UNIT01UnitsTopic)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($UNIT01UnitsTopic, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($UNIT01UnitsTopic, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($UNIT01UnitsTopic->fill($data)->save()){
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
     * @param  \App\Models\Units\UNIT01UnitsTopic  $UNIT01UnitsTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(UNIT01UnitsTopic $UNIT01UnitsTopic)
    {
        storageDelete($UNIT01UnitsTopic, 'path_image_icon');

        if($UNIT01UnitsTopic->delete()){
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

        $UNIT01UnitsTopics = UNIT01UnitsTopic::whereIn('id', $request->deleteAll)->get();
        foreach($UNIT01UnitsTopics as $UNIT01UnitsTopic){
            storageDelete($UNIT01UnitsTopic, 'path_image_icon');
        }

        if($deleted = UNIT01UnitsTopic::whereIn('id', $request->deleteAll)->delete()){
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
            UNIT01UnitsTopic::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
