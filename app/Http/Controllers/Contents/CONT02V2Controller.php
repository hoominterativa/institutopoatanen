<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT02V2Contents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class CONT02V2Controller extends Controller
{
    protected $path = 'uploads/Contents/CONT02V2/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT02V2Contents::sorting()->get();

        return view('Admin.cruds.Contents.CONT02V2.index', [
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
        return view('Admin.cruds.Contents.CONT02V2.create', [
            'cropSetting' => getCropImage('Contents', 'CONT02V2')
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

        if (CONT02V2Contents::create($data)) {
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.cont02v2.index');
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
     * @param  \App\Models\Contents\CONT02V2Contents  $CONT02V2Contents
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT02V2Contents $CONT02V2Contents)
    {
        return view('Admin.cruds.Contents.CONT02V2.edit', [
            'content' => $CONT02V2Contents,
            'cropSetting' => getCropImage('Contents', 'CONT02V2')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT02V2Contents  $CONT02V2Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT02V2Contents $CONT02V2Contents)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) {
            storageDelete($CONT02V2Contents, 'path_image');
            $data['path_image'] = $path_image;
        }
        if ($request->delete_path_image && !$path_image) {
            storageDelete($CONT02V2Contents, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_background_desktop = $helper->optimizeImage($request, 'path_image_background_desktop', $this->path, null, 100);
        if ($path_image_background_desktop) {
            storageDelete($CONT02V2Contents, 'path_image_background_desktop');
            $data['path_image_background_desktop'] = $path_image_background_desktop;
        }
        if ($request->delete_path_image_background_desktop && !$path_image_background_desktop) {
            storageDelete($CONT02V2Contents, 'path_image_background_desktop');
            $data['path_image_background_desktop'] = null;
        }

        $path_image_background_mobile = $helper->optimizeImage($request, 'path_image_background_mobile', $this->path, null, 100);
        if ($path_image_background_mobile) {
            storageDelete($CONT02V2Contents, 'path_image_background_mobile');
            $data['path_image_background_mobile'] = $path_image_background_mobile;
        }
        if ($request->delete_path_image_background_mobile && !$path_image_background_mobile) {
            storageDelete($CONT02V2Contents, 'path_image_background_mobile');
            $data['path_image_background_mobile'] = null;
        }

        if ($CONT02V2Contents->fill($data)->save()) {
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
     * @param  \App\Models\Contents\CONT02V2Contents  $CONT02V2Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT02V2Contents $CONT02V2Contents)
    {
        storageDelete($CONT02V2Contents, 'path_image_background_desktop');
        storageDelete($CONT02V2Contents, 'path_image_background_mobile');
        storageDelete($CONT02V2Contents, 'path_image');

        if ($CONT02V2Contents->delete()) {
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
        $CONT02V2Contentss = CONT02V2Contents::whereIn('id', $request->deleteAll)->get();
        foreach ($CONT02V2Contentss as $CONT02V2Contents) {
            storageDelete($CONT02V2Contents, 'path_image_background_desktop');
            storageDelete($CONT02V2Contents, 'path_image_background_mobile');
            storageDelete($CONT02V2Contents, 'path_image');
        }

        if ($deleted = CONT02V2Contents::whereIn('id', $request->deleteAll)->delete()) {
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
            CONT02V2Contents::where('id', $id)->update(['sorting' => $sorting]);
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
        $contents = CONT02V2Contents::active()->sorting()->get();

        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                foreach ($contents as $content) {
                    if ($content) $content->path_image_background_desktop = $content->path_image_background_mobile;
                }
            break;
        }

        return view('Client.pages.Contents.CONT02V2.section', [
            'contents' => $contents
        ]);
    }
}
