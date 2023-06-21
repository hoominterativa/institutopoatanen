<?php

namespace App\Http\Controllers\Contents;

use App\Models\Contents\CONT04Contents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Contents\CONT04ContentsSection;

class CONT04Controller extends Controller
{
    protected $path = 'uploads/Contents/CONT04/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $content = CONT04Contents::first();
        $section = CONT04ContentsSection::first();
        return view('Admin.cruds.Contents.CONT04.edit', [
            'content' => $content,
            'section' => $section,
            'cropSetting' => getCropImage('Contents', 'CONT04')
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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) $data['path_image'] = $path_image;

        if (CONT04Contents::create($data)) {
            Session::flash('success', 'Conteúdo cadastrado com sucesso');;
        } else {
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT04Contents  $CONT04Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT04Contents $CONT04Contents)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) {
            storageDelete($CONT04Contents, 'path_image');
            $data['path_image'] = $path_image;
        }
        if ($request->delete_path_image && !$path_image) {
            storageDelete($CONT04Contents, 'path_image');
            $data['path_image'] = null;
        }

        if ($CONT04Contents->fill($data)->save()) {
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        } else {
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar o conteúdo');
        }
        return redirect()->back();
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
            CONT04Contents::where('id', $id)->update(['sorting' => $sorting]);
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
                $section = CONT04ContentsSection::active()->first();
                if ($section) $section->path_image_desktop = $section->path_image_mobile;
                break;
            default:
                $section = CONT04ContentsSection::active()->first();
                break;
        }

        $content = CONT04Contents::first();
        return view('Client.pages.Contents.CONT04.section', [
            'content' => $content,
            'section' => $section
        ]);
    }
}
