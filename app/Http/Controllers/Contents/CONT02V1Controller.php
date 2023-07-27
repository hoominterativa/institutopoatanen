<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT02V1Contents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class CONT02V1Controller extends Controller
{
    protected $path = 'uploads/Contents/CONT02V1/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT02V1Contents::sorting()->get();

        return view('Admin.cruds.Contents.CONT02V1.index', [
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
        return view('Admin.cruds.Contents.CONT02V1.create', [
            'cropSetting' => getCropImage('Contents', 'CONT02V1')
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

        $path_image_background_desktop = $helper->optimizeImage($request, 'path_image_background_desktop', $this->path, null, 100);
        if ($path_image_background_desktop) $data['path_image_background_desktop'] = $path_image_background_desktop;

        $path_image_background_mobile = $helper->optimizeImage($request, 'path_image_background_mobile', $this->path, null, 100);
        if ($path_image_background_mobile) $data['path_image_background_mobile'] = $path_image_background_mobile;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) $data['path_image'] = $path_image;

        if (CONT02V1Contents::create($data)) {
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.cont02v1.index');
        } else {
            Storage::delete($path_image_background_desktop);
            Storage::delete($path_image_background_mobile);
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contents\CONT02V1Contents  $CONT02V1Contents
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT02V1Contents $CONT02V1Contents)
    {
        return view('Admin.cruds.Contents.CONT02V1.edit', [
            'content' => $CONT02V1Contents,
            'cropSetting' => getCropImage('Contents', 'CONT02V1')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT02V1Contents  $CONT02V1Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT02V1Contents $CONT02V1Contents)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) {
            storageDelete($CONT02V1Contents, 'path_image');
            $data['path_image'] = $path_image;
        }
        if ($request->delete_path_image && !$path_image) {
            storageDelete($CONT02V1Contents, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_background_desktop = $helper->optimizeImage($request, 'path_image_background_desktop', $this->path, null, 100);
        if ($path_image_background_desktop) {
            storageDelete($CONT02V1Contents, 'path_image_background_desktop');
            $data['path_image_background_desktop'] = $path_image_background_desktop;
        }
        if ($request->delete_path_image_background_desktop && !$path_image_background_desktop) {
            storageDelete($CONT02V1Contents, 'path_image_background_desktop');
            $data['path_image_background_desktop'] = null;
        }

        $path_image_background_mobile = $helper->optimizeImage($request, 'path_image_background_mobile', $this->path, null, 100);
        if ($path_image_background_mobile) {
            storageDelete($CONT02V1Contents, 'path_image_background_mobile');
            $data['path_image_background_mobile'] = $path_image_background_mobile;
        }
        if ($request->delete_path_image_background_mobile && !$path_image_background_mobile) {
            storageDelete($CONT02V1Contents, 'path_image_background_mobile');
            $data['path_image_background_mobile'] = null;
        }

        if ($CONT02V1Contents->fill($data)->save()) {
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        } else {
            Storage::delete($path_image_background_desktop);
            Storage::delete($path_image_background_mobile);
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT02V1Contents  $CONT02V1Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT02V1Contents $CONT02V1Contents)
    {
        storageDelete($CONT02V1Contents, 'path_image_background_desktop');
        storageDelete($CONT02V1Contents, 'path_image_background_mobile');
        storageDelete($CONT02V1Contents, 'path_image');

        if ($CONT02V1Contents->delete()) {
            Session::flash('success', 'Conteúdo deletado com sucessso');
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
        $CONT02V1Contentss = CONT02V1Contents::whereIn('id', $request->deleteAll)->get();
        foreach ($CONT02V1Contentss as $CONT02V1Contents) {
            storageDelete($CONT02V1Contents, 'path_image_background_desktop');
            storageDelete($CONT02V1Contents, 'path_image_background_mobile');
            storageDelete($CONT02V1Contents, 'path_image');
        }

        if ($deleted = CONT02V1Contents::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' Conteúdos deletados com sucessso']);
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
            CONT02V1Contents::where('id', $id)->update(['sorting' => $sorting]);
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
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $contents = CONT02V1Contents::active()->sorting()->get();
                foreach ($contents as $content) {
                    if ($content) $content->path_image_background_desktop = $content->path_image_background_mobile;
                }
                break;
            default:
                $contents = CONT02V1Contents::active()->sorting()->get();
                break;
        }

        return view('Client.pages.Contents.CONT02V1.section', [
            'contents' => $contents
        ]);
    }
}
