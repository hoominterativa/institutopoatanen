<?php

namespace App\Http\Controllers\Portals;

use App\Models\Portals\POTA01PortalsPodcast;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use Carbon\Carbon;

class POTA01PodcastController extends Controller
{
    protected $path = 'uploads/Portals/POTA01/images/';
    protected $pathArchive = 'uploads/Portals/POTA01/archives/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $podcasts =  POTA01PortalsPodcast::paginate('32');
        return view('Admin.cruds.Portals.POTA01.Podcast.index',[
            'podcasts' => $podcasts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Portals.POTA01.Podcast.create',[
            'cropSetting' => getCropImage('Portals', 'POTA01')
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

        $path_image_thumbnail = $helper->optimizeImage($request, 'path_image_thumbnail', $this->path, null,100);
        if($path_image_thumbnail) $data['path_image_thumbnail'] = $path_image_thumbnail;

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->pathArchive);
        if($path_archive) $data['path_archive'] = $path_archive;

        $data['featured_home'] = $request->featured_home?1:0;
        $data['active'] = $request->active?1:0;

        if ($request->publishing) {
            $data['publishing'] = Carbon::createFromFormat('d/m/Y', $request->publishing)->format('Y-m-d');
        }

        if(POTA01PortalsPodcast::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
            return redirect()->route('admin.pota01.podcast.index');
        }else{
            Storage::delete($path_image_thumbnail);
            Storage::delete($path_archive);
            Session::flash('error', 'Erro ao cadastradar informações');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portals\POTA01PortalsPodcast  $POTA01PortalsPodcast
     * @return \Illuminate\Http\Response
     */
    public function edit(POTA01PortalsPodcast $POTA01PortalsPodcast)
    {
        $POTA01PortalsPodcast->publishing = Carbon::parse($POTA01PortalsPodcast->publishing)->format('d/m/Y');
        return view('Admin.cruds.Portals.POTA01.Podcast.edit',[
            'podcast' => $POTA01PortalsPodcast,
            'cropSetting' => getCropImage('Portals', 'POTA01')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portals\POTA01PortalsPodcast  $POTA01PortalsPodcast
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, POTA01PortalsPodcast $POTA01PortalsPodcast)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_thumbnail = $helper->optimizeImage($request, 'path_image_thumbnail', $this->path, null,100);
        if($path_image_thumbnail){
            storageDelete($POTA01PortalsPodcast, 'path_image_thumbnail');
            $data['path_image_thumbnail'] = $path_image_thumbnail;
        }
        if($request->delete_path_image && !$path_image_thumbnail){
            storageDelete($POTA01PortalsPodcast, 'path_image_thumbnail');
            $data['path_image_thumbnail'] = null;
        }

        $path_archive = $helper->uploadArchive($request, 'path_archive', $this->pathArchive);
        if($path_archive){
            storageDelete($POTA01PortalsPodcast, 'path_archive');
            $data['path_archive'] = $path_archive;
        }
        if($request->delete_path_archive && !$path_archive){
            storageDelete($POTA01PortalsPodcast, 'path_archive');
            $data['path_archive'] = null;
        }

        $data['featured_home'] = $request->featured_home?1:0;
        $data['active'] = $request->active?1:0;

        if ($request->publishing) {
            $data['publishing'] = Carbon::createFromFormat('d/m/Y', $request->publishing)->format('Y-m-d');
        }

        if($POTA01PortalsPodcast->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image_thumbnail);
            Storage::delete($path_archive);
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portals\POTA01PortalsPodcast  $POTA01PortalsPodcast
     * @return \Illuminate\Http\Response
     */
    public function destroy(POTA01PortalsPodcast $POTA01PortalsPodcast)
    {
        storageDelete($POTA01PortalsPodcast, 'path_image_thumbnail');
        storageDelete($POTA01PortalsPodcast, 'path_archive');

        if($POTA01PortalsPodcast->delete()){
            Session::flash('success', 'Item deletado com sucessso');
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
        $POTA01PortalsPodcasts = POTA01PortalsPodcast::whereIn('id', $request->deleteAll)->get();
        foreach($POTA01PortalsPodcasts as $POTA01PortalsPodcast){
            storageDelete($POTA01PortalsPodcast, 'path_image_thumbnail');
            storageDelete($POTA01PortalsPodcast, 'path_archive');
        }

        if($deleted = POTA01PortalsPodcast::whereIn('id', $request->deleteAll)->delete()){
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
            POTA01PortalsPodcast::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
