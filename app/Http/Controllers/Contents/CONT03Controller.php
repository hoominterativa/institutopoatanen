<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT03Contents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class CONT03Controller extends Controller
{
    protected $path = 'uploads/Contents/CONT03/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT03Contents::sorting()->get();
        return view('Admin.cruds.Contents.CONT03.index', [
            'contents' => $contents
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Contents.CONT03.create', [
            'cropSetting' => getCropImage('Contents', 'CONT03')
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

        $data['active'] = $request->active ? 1 : 0;
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image_center = $helper->optimizeImage($request, 'path_image_center', $this->path, null, 100);
        if ($path_image_center) $data['path_image_center'] = $path_image_center;

        $path_image_right = $helper->optimizeImage($request, 'path_image_right', $this->path, null, 100);
        if ($path_image_right) $data['path_image_right'] = $path_image_right;

        $path_image_background_desktop = $helper->optimizeImage($request, 'path_image_background_desktop', $this->path, null, 100);
        if ($path_image_background_desktop) $data['path_image_background_desktop'] = $path_image_background_desktop;

        $path_image_background_mobile = $helper->optimizeImage($request, 'path_image_background_mobile', $this->path, null, 100);
        if ($path_image_background_mobile) $data['path_image_background_mobile'] = $path_image_background_mobile;

        if (CONT03Contents::create($data)) {
            Session::flash('success', 'Informações cadastradas com sucesso');
            return redirect()->route('admin.cont03.index');
        } else {
            Storage::delete($path_image_center);
            Storage::delete($path_image_right);
            Storage::delete($path_image_background_mobile);
            Storage::delete($path_image_background_desktop);
            Session::flash('success', 'Erro ao cadastradar informações');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slides\SLID01Slides  $SLID01Slides
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT03Contents $CONT03Contents)
    {
        return view('Admin.cruds.Contents.CONT03.edit', [
            'content' => $CONT03Contents,
            'cropSetting' => getCropImage('Contents', 'CONT03')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT03Contents  $CONT03Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT03Contents $CONT03Contents)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        // path_image_center
        $path_image_center = $helper->optimizeImage($request, 'path_image_center', $this->path, null, 100);
        if ($path_image_center) {
            storageDelete($CONT03Contents, 'path_image_center');
            $data['path_image_center'] = $path_image_center;
        }
        if ($request->delete_path_image_center && !$path_image_center) {
            storageDelete($CONT03Contents, 'path_image_center');
            $data['path_image_center'] = null;
        }

        //path_image_right
        $path_image_right = $helper->optimizeImage($request, 'path_image_right', $this->path, null, 100);
        if ($path_image_right) {
            storageDelete($CONT03Contents, 'path_image_right');
            $data['path_image_right'] = $path_image_right;
        }
        if ($request->delete_path_image_right && !$path_image_right) {
            storageDelete($CONT03Contents, 'path_image_right');
            $data['path_image_right'] = null;
        }

        // path_image_background_desktop
        $path_image_background_desktop = $helper->optimizeImage($request, 'path_image_background_desktop', $this->path, null, 100);
        if ($path_image_background_desktop) {
            storageDelete($CONT03Contents, 'path_image_background_desktop');
            $data['path_image_background_desktop'] = $path_image_background_desktop;
        }
        if ($request->delete_path_image_background_desktop && !$path_image_background_desktop) {
            storageDelete($CONT03Contents, 'path_image_background_desktop');
            $data['path_image_background_desktop'] = null;
        }

        // path_image_background_desktop
        $path_image_background_mobile = $helper->optimizeImage($request, 'path_image_background_mobile', $this->path, null, 100);
        if ($path_image_background_mobile) {
            storageDelete($CONT03Contents, 'path_image_background_mobile');
            $data['path_image_background_mobile'] = $path_image_background_mobile;
        }
        if ($request->delete_path_image_background_mobile && !$path_image_background_mobile) {
            storageDelete($CONT03Contents, 'path_image_background_mobile');
            $data['path_image_background_mobile'] = null;
        }

        if ($CONT03Contents->fill($data)->save()) {
            Session::flash('success', 'Informações atualizadas com sucesso');
        } else {
            Storage::delete($path_image_center);
            Storage::delete($path_image_right);
            Storage::delete($path_image_background_desktop);
            Storage::delete($path_image_background_mobile);
            Session::flash('success', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT03Contents  $CONT03Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT03Contents $CONT03Contents)
    {
        storageDelete($CONT03Contents, 'path_image_center');
        storageDelete($CONT03Contents, 'path_image_right');
        storageDelete($CONT03Contents, 'path_image_background_desktop');
        storageDelete($CONT03Contents, 'path_image_background_mobile');

        if ($CONT03Contents->delete()) {
            Session::flash('success', 'Informações deletadas com sucessso');
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
        $CONT03Contentss = CONT03Contents::whereIn('id', $request->deleteAll)->get();
        foreach ($CONT03Contentss as $CONT03Contents) {
            storageDelete($CONT03Contents, 'path_image_center');
            storageDelete($CONT03Contents, 'path_image_right');
            storageDelete($CONT03Contents, 'path_image_background_desktop');
            storageDelete($CONT03Contents, 'path_image_background_mobile');
        }

        if ($deleted = CONT03Contents::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' itens deletados com sucessso']);
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
        foreach ($request->arrId as $sorting => $id) {
            CONT03Contents::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $contents = CONT03Contents::active()->sorting()->get();
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                foreach ($contents as $content) {
                    if ($content) $content->path_image_background_desktop = $content->path_image_background_mobile;
                }
            break;
        }

        return view('Client.pages.Contents.CONT03.section', [
            'contents' => $contents
        ]);
    }
}
