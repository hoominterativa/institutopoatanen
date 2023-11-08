<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV09ServicesFeedback;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SERV09FeedbackController extends Controller
{
    protected $path = 'uploads/Services/SERV09/images/';

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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(SERV09ServicesFeedback::create($data)){
            Session::flash('success', 'Feedback cadastrado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o feedback');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV09ServicesFeedback  $SERV09ServicesFeedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV09ServicesFeedback $SERV09ServicesFeedback)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV09ServicesFeedback, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV09ServicesFeedback, 'path_image');
            $data['path_image'] = null;
        }

        if($SERV09ServicesFeedback->fill($data)->save()){
            Session::flash('success', 'Feedback atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar feedback');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV09ServicesFeedback  $SERV09ServicesFeedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV09ServicesFeedback $SERV09ServicesFeedback)
    {
        storageDelete($SERV09ServicesFeedback, 'path_image');

        if($SERV09ServicesFeedback->delete()){
            Session::flash('success', 'Feedback deletado com sucessso');
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

        $SERV09ServicesFeedbacks = SERV09ServicesFeedback::whereIn('id', $request->deleteAll)->get();
        foreach($SERV09ServicesFeedbacks as $SERV09ServicesFeedback){
            storageDelete($SERV09ServicesFeedback, 'path_image');
        }

        if($deleted = SERV09ServicesFeedback::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' feedbacks deletados com sucessso']);
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
            SERV09ServicesFeedback::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
