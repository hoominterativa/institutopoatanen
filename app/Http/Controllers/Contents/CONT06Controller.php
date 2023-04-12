<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT06Contents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class CONT06Controller extends Controller
{
    protected $path = 'uploads/Contents/CONT06/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT06Contents::sorting()->paginate(15);
        return view('Admin.cruds.Contents.CONT06.index', [
            'contents' => $contents,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Contents.CONT06.create', [
            'cropSetting' => getCropImage('Contents', 'CONT06')
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

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if ($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if ($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if ($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) $data['path_image'] = $path_image;

        if (CONT06Contents::create($data)) {
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.cont06.index');
        } else {
            Storage::delete($path_image_icon);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Storage::delete($path_image);
            Session::flash('success', 'Erro ao cadastradar o conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contents\CONT06Contents  $CONT06Contents
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT06Contents $CONT06Contents)
    {
        return view('Admin.cruds.Contents.CONT06.edit', [
            'content' => $CONT06Contents,
            'cropSetting' => getCropImage('Contents', 'CONT06')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT06Contents  $CONT06Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT06Contents $CONT06Contents)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if ($path_image_icon) {
            storageDelete($CONT06Contents, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if ($request->delete_path_image_icon && !$path_image_icon) {
            storageDelete($CONT06Contents, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if ($path_image_desktop) {
            storageDelete($CONT06Contents, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if ($request->delete_path_image_desktop && !$path_image_desktop) {
            storageDelete($CONT06Contents, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if ($path_image_mobile) {
            storageDelete($CONT06Contents, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if ($request->delete_path_image_mobile && !$path_image_mobile) {
            storageDelete($CONT06Contents, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) {
            storageDelete($CONT06Contents, 'path_image');
            $data['path_image'] = $path_image;
        }
        if ($request->delete_path_image && !$path_image) {
            storageDelete($CONT06Contents, 'path_image');
            $data['path_image'] = null;
        }

        if ($CONT06Contents->fill($data)->save()) {
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        } else {
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_mobile);
            Storage::delete($path_image);
            Session::flash('success', 'Erro ao atualizar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT06Contents  $CONT06Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT06Contents $CONT06Contents)
    {
        storageDelete($CONT06Contents, 'path_image');
        storageDelete($CONT06Contents, 'path_image_icon');
        storageDelete($CONT06Contents, 'path_image_desktop');
        storageDelete($CONT06Contents, 'path_image_mobile');

        if ($CONT06Contents->delete()) {
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
        $CONT06Contentss = CONT06Contents::whereIn('id', $request->deleteAll)->get();
        foreach ($CONT06Contentss as $CONT06Contents) {
            storageDelete($CONT06Contents, 'path_image');
            storageDelete($CONT06Contents, 'path_image_icon');
            storageDelete($CONT06Contents, 'path_image_mobile');
            storageDelete($CONT06Contents, 'path_image_desktop');
        }


        if ($deleted = CONT06Contents::whereIn('id', $request->deleteAll)->delete()) {
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
            CONT06Contents::where('id', $id)->update(['sorting' => $sorting]);
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
                $contents = CONT06Contents::active()->sorting()->get();
                foreach ($contents as $content) {
                    if ($content) $content->path_image_desktop = $content->path_image_mobile;
                }
                break;
            default:
                $contents = CONT06Contents::active()->sorting()->get();
                break;
        }

        return view('Client.pages.Contents.CONT06.section', [
            'contents' => $contents,
        ]);
    }
}
