<?php

namespace App\Http\Controllers\Portfolios;

use App\Models\Portfolios\PORT06PortfoliosSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Helpers\HelperArchive;


class PORT06SectionController extends Controller
{
    protected $path = 'uploads/Module/Code/images/';

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;

        if (PORT06PortfoliosSection::create($data)) {
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.code.index');
        } else {
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    public function update(Request $request, PORT06PortfoliosSection $PORT06PortfoliosSection)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;

        if ($PORT06PortfoliosSection->fill($data)->save()) {
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.code.index');
        } else {
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    public function storeBanner(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;

        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);

        if ($path_image) $data['path_image'] = $path_image;


        if (PORT06PortfoliosSection::create($data)) {
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.code.index');
        } else {
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    public function updateBanner(Request $request, PORT06PortfoliosSection $PORT06PortfoliosSection)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;
        $helper = new HelperArchive();


        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) {
            storageDelete($PORT06PortfoliosSection, 'path_image');
            $data['path_image'] = $path_image;
        }
        if ($request->delete_path_image && !$path_image) {
            storageDelete($PORT06PortfoliosSection, 'path_image');
            $data['path_image'] = null;
        }


        if ($PORT06PortfoliosSection->fill($data)->save()) {
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.code.index');
        } else {
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }
}
