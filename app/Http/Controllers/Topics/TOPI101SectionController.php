<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI101TopicsSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TOPI101SectionController extends Controller
{
    protected $path = 'uploads/Topics/TOPI101/images/';

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

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if ($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if ($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if (TOPI101TopicsSection::create($data)) {
            Session::flash('success', 'Seção cadastrada com sucesso');
        } else {
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar a seção');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI101TopicsSection  $TOPI101TopicsSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI101TopicsSection $TOPI101TopicsSection)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if ($path_image_desktop) {
            storageDelete($TOPI101TopicsSection, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if ($request->delete_path_image_desktop && !$path_image_desktop) {
            storageDelete($TOPI101TopicsSection, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if ($path_image_mobile) {
            storageDelete($TOPI101TopicsSection, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if ($request->delete_path_image_mobile && !$path_image_mobile) {
            storageDelete($TOPI101TopicsSection, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        if ($TOPI101TopicsSection->fill($data)->save()) {
            Session::flash('success', 'Seção atualizada com sucesso');
        } else {
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }
}
