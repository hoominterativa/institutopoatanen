<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI01Topics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Topics\TOPI01TopicsSection;

class TOPI01Controller extends Controller
{
    protected $path = 'uploads/Topics/TOPI01/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI01Topics::sorting()->get();
        $section = TOPI01TopicsSection::first();

        return view('Admin.cruds.Topics.TOPI01.index', [
            'topics' => $topics,
            'section' => $section,
            'cropSetting' => getCropImage('Topics', 'TOPI01')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Topics.TOPI01.create', [
            'cropSetting' => getCropImage('Topics', 'TOPI01')
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
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) $data['path_image'] = $path_image;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if ($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if (TOPI01Topics::create($data)) {
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi01.index');
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao cadastradar tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI01Topics  $TOPI01Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI01Topics $TOPI01Topics)
    {
        return view('Admin.cruds.Topics.TOPI01.edit', [
            'topic' => $TOPI01Topics,
            'cropSetting' => getCropImage('Topics', 'TOPI01')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI01Topics  $TOPI01Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI01Topics $TOPI01Topics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) {
            storageDelete($TOPI01Topics, 'path_image');
            $data['path_image'] = $path_image;
        }
        if ($request->delete_path_image && !$path_image) {
            storageDelete($TOPI01Topics, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if ($path_image_icon) {
            storageDelete($TOPI01Topics, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if ($request->delete_path_image_icon && !$path_image_icon) {
            storageDelete($TOPI01Topics, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if ($TOPI01Topics->fill($data)->save()) {
            Session::flash('success', 'Tópico atualizado com sucesso');
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI01Topics  $TOPI01Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI01Topics $TOPI01Topics)
    {
        storageDelete($TOPI01Topics, 'path_image');
        storageDelete($TOPI01Topics, 'path_image_icon');

        if ($TOPI01Topics->delete()) {
            Session::flash('success', 'Tópico deletado com sucessso');
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
        $TOPI01Topicss = TOPI01Topics::whereIn('id', $request->deleteAll)->get();
        foreach ($TOPI01Topicss as $TOPI01Topics) {
            storageDelete($TOPI01Topics, 'path_image');
            storageDelete($TOPI01Topics, 'path_image_icon');
        }

        if ($deleted = TOPI01Topics::whereIn('id', $request->deleteAll)->delete()) {
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
            TOPI01Topics::where('id', $id)->update(['sorting' => $sorting]);
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
        $topics = TOPI01Topics::active()->sorting()->get();
        $section = TOPI01TopicsSection::firstOrCreate();
        return view('Client.pages.Topics.TOPI01.section', [
            'topics' => $topics,
            'section' => $section,
        ]);
    }
}
