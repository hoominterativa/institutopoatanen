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
    protected $path = 'uploads/Module/Code/images/';

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;

        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);

        if ($path_image) $data['path_image'] = $path_image;


        if (PORT06PortfoliosGallery::create($data)) {
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->back();
        } else {
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    public function update(Request $request, PORT06PortfoliosGallery $PORT06PortfoliosGallery)
    {
        $data = $request->all();

        $helper = new HelperArchive();
        $data['active'] = $request->active ? 1 : 0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) {
            storageDelete($PORT06PortfoliosGallery, 'path_image');
            $data['path_image'] = $path_image;
        }
        if ($request->delete_path_image && !$path_image) {
            storageDelete($PORT06PortfoliosGallery, 'path_image');
            $data['path_image'] = null;
        }

        if ($PORT06PortfoliosGallery->fill($data)->save()) {
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->back();
        } else {
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
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
