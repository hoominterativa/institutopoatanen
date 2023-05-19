<?php

namespace App\Http\Controllers\Portals;

use App\Models\Portals\POTA01PortalsAdverts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portals\POTA01PortalsCategory;
use Carbon\Carbon;

class POTA01AdvertsController extends Controller
{
    protected $path = 'uploads/Portals/POTA01/images/';

    // homeBottomPodcast
    // bottomLatestNews
    // category
    // categoryInnerBeginPage
    // categoryInnerEndPage
    // blogInner
    // podcastBeforeArticle
    // podcastAfterArticle

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->has('type')) return view('Admin.cruds.Portals.POTA01.Adverts.panel');

        switch ($request->type) {
            case 'category':
                $adverts = POTA01PortalsAdverts::with('category')->whereIn('position', ['category', 'categoryInnerBeginPage', 'categoryInnerEndPage'])->sorting()->get();
                $titlePage = 'Anúncios das Categorias';
            break;
            case 'home':
                $adverts = POTA01PortalsAdverts::whereIn('position', ['homeBottomPodcast', 'bottomLatestNews'])->sorting()->get();
                $titlePage = 'Anúncios da Home';
            break;
            case 'podcast':
                $adverts = POTA01PortalsAdverts::whereIn('position', ['podcastBeforeArticle', 'podcastAfterArticle'])->sorting()->get();
                $titlePage = 'Anúncios Podcast';
            break;
            case 'blog':
                $adverts = POTA01PortalsAdverts::whereIn('position', ['blogInner'])->whereNull('blog_id')->sorting()->get();
                $titlePage = 'Anúncios das Internas dos Artigos';
            break;
        }

        return view('Admin.cruds.Portals.POTA01.Adverts.index',[
            'titlePage' => $titlePage,
            'adverts' => $adverts,
            'type' => $request->type,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!$request->has('type')) return redirect()->back();
        switch ($request->type) {
            case 'category':
                $positions = [
                    'categoryInnerBeginPage' => 'Início da página',
                    'categoryInnerEndPage' => 'Fim da Página',
                ];
            break;
            case 'home':
                $positions = [
                    'homeBottomPodcast' => 'Abaixo do Padcast',
                    'bottomLatestNews' => 'Abaixo das Últimas Notícias',
                ];
            break;
            case 'podcast':
                $positions = [
                    'podcastBeforeArticle' => 'Antes dos Artigos',
                    'podcastAfterArticle' => 'Depois dos Artigos',
                ];
            break;
            case 'blog':
                $positions = [
                    'blogInner' => 'Final da página',
                ];
            break;
        }

        $categories = POTA01PortalsCategory::active()->sorting()->pluck('title','id');
        return view('Admin.cruds.Portals.POTA01.Adverts.create',[
            'request' => $request,
            'categories' => $categories,
            'positions' => $positions,
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

        $path_image = $helper->uploadArchive($request, 'path_image', $this->path);
        if($path_image) $data['path_image'] = $path_image;

        $data['active'] = $request->active?1:0;

        $dateStart = $request->date_start.' '.$request->hour_start;
        $dateEnd = $request->date_end.' '.$request->hour_end;

        if ($request->date_start) {
            $data['date_start'] = Carbon::createFromFormat('d/m/Y H:i', $dateStart)->format('Y-m-d H:i:s');
        }

        if ($request->date_end) {
            $data['date_end'] = Carbon::createFromFormat('d/m/Y H:i', $dateEnd)->format('Y-m-d H:i:s');
        }

        if(POTA01PortalsAdverts::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.pota01.adverts.index', ['type' => $request->type]);
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portals\POTA01PortalsAdverts  $POTA01PortalsAdverts
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, POTA01PortalsAdverts $POTA01PortalsAdverts)
    {
        if(!$request->has('type')) return redirect()->back();
        $categories = POTA01PortalsCategory::active()->sorting()->pluck('title','id');

        switch ($request->type) {
            case 'category':
                $positions = [
                    'categoryInnerBeginPage' => 'Início da página',
                    'categoryInnerEndPage' => 'Final da Página',
                ];
            break;
            case 'home':
                $positions = [
                    'homeBottomPodcast' => 'Abaixo do Padcast',
                    'bottomLatestNews' => 'Abaixo das Últimas Notícias',
                ];
            break;
            case 'podcast':
                $positions = [
                    'podcastBeforeArticle' => 'Antes dos Artigos',
                    'podcastAfterArticle' => 'Depois dos Artigos',
                ];
            break;
            case 'blog':
                $positions = [
                    'blogInner' => 'Final da página',
                ];
            break;
        }

        $dateStart = Carbon::createFromFormat('Y-m-d H:i:s', $POTA01PortalsAdverts->date_start);
        $dateEnd = Carbon::createFromFormat('Y-m-d H:i:s', $POTA01PortalsAdverts->date_end);

        $POTA01PortalsAdverts->hour_start = $dateStart->format('H:i');
        $POTA01PortalsAdverts->date_start = $dateStart->format('d/m/Y');
        $POTA01PortalsAdverts->date_end = $dateEnd->format('d/m/Y');
        $POTA01PortalsAdverts->hour_end = $dateEnd->format('H:i');

        return view('Admin.cruds.Portals.POTA01.Adverts.edit',[
            'request' => $request,
            'advert' => $POTA01PortalsAdverts,
            'categories' => $categories,
            'positions' => $positions,
            'cropSetting' => getCropImage('Portals', 'POTA01')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portals\POTA01PortalsAdverts  $POTA01PortalsAdverts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, POTA01PortalsAdverts $POTA01PortalsAdverts)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image = $helper->uploadArchive($request, 'path_image', $this->path);
        if($path_image){
            storageDelete($POTA01PortalsAdverts, 'path_image');
            $data['path_image'] = $path_image;
        }

        if($request->delete_path_image && !$path_image){
            storageDelete($POTA01PortalsAdverts, 'path_image');
            $data['path_image'] = null;
        }

        $data['active'] = $request->active?1:0;

        $dateStart = $request->date_start.' '.$request->hour_start;
        $dateEnd = $request->date_end.' '.$request->hour_end;

        if ($request->date_start) {
            $data['date_start'] = Carbon::createFromFormat('d/m/Y H:i', $dateStart)->format('Y-m-d H:i:s');
        }

        if ($request->date_end) {
            $data['date_end'] = Carbon::createFromFormat('d/m/Y H:i', $dateEnd)->format('Y-m-d H:i:s');
        }

        if($POTA01PortalsAdverts->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portals\POTA01PortalsAdverts  $POTA01PortalsAdverts
     * @return \Illuminate\Http\Response
     */
    public function destroy(POTA01PortalsAdverts $POTA01PortalsAdverts)
    {
        storageDelete($POTA01PortalsAdverts, 'path_image');

        if($POTA01PortalsAdverts->delete()){
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
        $POTA01PortalsAdvertss = POTA01PortalsAdverts::whereIn('id', $request->deleteAll)->get();
        foreach($POTA01PortalsAdvertss as $POTA01PortalsAdverts){
            storageDelete($POTA01PortalsAdverts, 'path_image');
        }

        if($deleted = POTA01PortalsAdverts::whereIn('id', $request->deleteAll)->delete()){
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
            POTA01PortalsAdverts::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
