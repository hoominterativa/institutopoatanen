<?php

namespace App\Http\Controllers\Portfolios;

use App\Models\Portfolios\PORT06PortfoliosGallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class PORT06GalleryController extends Controller
{
    protected $path = 'uploads/Portfolios/PORT06/images/Gallery/';

    public function store(Request $request)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['featured'] = $request->featured?1:0;
        $data['link_video'] = isset($data['link_video']) ? getUri($data['link_video']) : null;

        $path_image =  $helper->uploadMultipleImage($request, 'path_image', $this->path, null,100);

        foreach ($path_image as $image) {
            $data['path_image'] = $image;
            PORT06PortfoliosGallery::create($data);
        }

        return Response::json(['status' => 'success', 'countUploads' => COUNT($path_image)]);
    }

    public function update(Request $request, PORT06PortfoliosGallery $PORT06PortfoliosGallery)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['featured'] = $request->featured?1:0;
        $data['link_video'] = isset($data['link_video']) ? getUri($data['link_video']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($PORT06PortfoliosGallery, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($PORT06PortfoliosGallery, 'path_image');
            $data['path_image'] = null;
        }

        if($PORT06PortfoliosGallery->fill($data)->save()){
            Session::flash('success', 'Galeria atualizada com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar a galeria');
        }
        return redirect()->back();
    }


    public function destroy(PORT06PortfoliosGallery $PORT06PortfoliosGallery)
    {
        storageDelete($PORT06PortfoliosGallery, 'path_image');

        if ($PORT06PortfoliosGallery->delete()) {
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }


    public function destroySelected(Request $request)
    {

        $PORT06PortfoliosGallerys = PORT06PortfoliosGallery::whereIn('id', $request->deleteAll)->get();
        foreach ($PORT06PortfoliosGallerys as $PORT06PortfoliosGallery) {
            storageDelete($PORT06PortfoliosGallery, 'path_image');
        }


        if ($deleted = PORT06PortfoliosGallery::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' itens deletados com sucessso']);
        }
    }

    public function sorting(Request $request)
    {
        foreach ($request->arrId as $sorting => $id) {
            PORT06PortfoliosGallery::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
