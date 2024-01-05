<?php

namespace App\Http\Controllers\Topics;

use App\Models\Topics\TOPI101Topics;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Topics\TOPI101TopicsSection;

class TOPI101Controller extends Controller
{
    protected $path = 'uploads/Topics/TOPI101/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI101Topics::active()->sorting()->get();
        $section = TOPI101TopicsSection::first();
        return view('Admin.cruds.Topics.TOPI101.index', [
            'topics' => $topics,
            'section' => $section,
            'cropSetting' => getCropImage('Topics', 'TOPI101')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Topics.TOPI101.create', [
            'cropSetting' => getCropImage('Topics', 'TOPI101')
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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) $data['path_image'] = $path_image;

        if (TOPI101Topics::create($data)) {
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi101.index');
        } else {
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI101Topics  $TOPI101Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI101Topics $TOPI101Topics)
    {
        return view('Admin.cruds.Topics.TOPI101.edit', [
            'topic' => $TOPI101Topics,
            'cropSetting' => getCropImage('Topics', 'TOPI101')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI101Topics  $TOPI101Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI101Topics $TOPI101Topics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) {
            storageDelete($TOPI101Topics, 'path_image');
            $data['path_image'] = $path_image;
        }
        if ($request->delete_path_image && !$path_image) {
            storageDelete($TOPI101Topics, 'path_image');
            $data['path_image'] = null;
        }

        if ($TOPI101Topics->fill($data)->save()) {
            Session::flash('success', 'Tópico atualizado com sucesso');
        } else {
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI101Topics  $TOPI101Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI101Topics $TOPI101Topics)
    {
        storageDelete($TOPI101Topics, 'path_image');

        if ($TOPI101Topics->delete()) {
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

        $TOPI101Topicss = TOPI101Topics::whereIn('id', $request->deleteAll)->get();
        foreach ($TOPI101Topicss as $TOPI101Topics) {
            storageDelete($TOPI101Topics, 'path_image');
        }

        if ($deleted = TOPI101Topics::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' Tópicos deletados com sucessso']);
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
            TOPI101Topics::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    public static function section()
    {
        $section = TOPI101TopicsSection::active()->first();
        $topics = TOPI101Topics::active()->sorting()->get();
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if($section) $section->path_image_desktop = $section->path_image_mobile;
            break;
        }

        return view('Client.pages.Topics.TOPI101.section', [
            'topics' => $topics,
            'section' => $section
        ]);
    }
}
