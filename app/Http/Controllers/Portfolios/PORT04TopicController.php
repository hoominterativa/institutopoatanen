<?php

namespace App\Http\Controllers\Portfolios;

use App\Models\Portfolios\PORT04PortfoliosTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class PORT04TopicController extends Controller
{
    protected $path = 'uploads/Portfolios/PORT04/images/';

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

        if(PORT04PortfoliosTopic::create($data)){
            Session::flash('success', 'Iformações cadastradas com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao cadastradar as informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT04PortfoliosTopic  $PORT04PortfoliosTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT04PortfoliosTopic $PORT04PortfoliosTopic)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($PORT04PortfoliosTopic, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($PORT04PortfoliosTopic, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($PORT04PortfoliosTopic->fill($data)->save()){
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
     * @param  \App\Models\Portfolios\PORT04PortfoliosTopic  $PORT04PortfoliosTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT04PortfoliosTopic $PORT04PortfoliosTopic)
    {
        storageDelete($PORT04PortfoliosTopic, 'path_image_icon');

        if($PORT04PortfoliosTopic->delete()){
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
        $PORT04PortfoliosTopics = PORT04PortfoliosTopic::whereIn('id', $request->deleteAll)->get();
        foreach($PORT04PortfoliosTopics as $PORT04PortfoliosTopic){
            storageDelete($PORT04PortfoliosTopic, 'path_image_icon');
        }

        if($deleted = PORT04PortfoliosTopic::whereIn('id', $request->deleteAll)->delete()){
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
            PORT04PortfoliosTopic::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
