<?php

namespace App\Http\Controllers\Portfolios;

use App\Models\Portfolios\PORT06PortfoliosSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Helpers\HelperArchive;
use Illuminate\Support\Facades\Storage;

class PORT06SectionController extends Controller
{
    protected $path = 'uploads/Module/Code/images/';

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active_section'] = $request->active_section ? 1 : 0;

        $data['active_banner'] = $request->active_banner ? 1 : 0;


        if (PORT06PortfoliosSection::create($data)) {
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->back();
        } else {
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    public function update(Request $request, PORT06PortfoliosSection $PORT06PortfoliosSection)
    {
        $data = $request->all();

        $data['active_section'] = $request->active_section ? 1 : 0;
        
        $data['active_banner'] = $request->active_banner ? 1 : 0;

        $helper = new HelperArchive();

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null, 100);
        if ($path_image_desktop_banner) {
            storageDelete($PORT06PortfoliosSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if ($request->delete_path_image_desktop_banner && !$path_image_desktop_banner) {
            storageDelete($PORT06PortfoliosSection, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }
        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null, 100);
        if ($path_image_mobile_banner) {
            storageDelete($PORT06PortfoliosSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if ($request->delete_path_image_mobile_banner && !$path_image_mobile_banner) {
            storageDelete($PORT06PortfoliosSection, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }

        if ($PORT06PortfoliosSection->fill($data)->save()) {
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->back();
        } else {
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }
}
