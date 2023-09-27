<?php

namespace App\Http\Controllers\Topics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Topics\TOPI102Topics;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Topics\TOPI102TopicsSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Topics\TOPI102TopicsFeaturedTopics;

class TOPI102Controller extends Controller
{
    protected $path = 'uploads/Topics/TOPI102/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = TOPI102Topics::sorting()->paginate(10);
        $section = TOPI102TopicsSection::first();
        $featuredtopics = TOPI102TopicsFeaturedTopics::sorting()->paginate(6);

        return view('Admin.cruds.Topics.TOPI102.index', [
            'topics' => $topics,
            'section' => $section,
            'featuredtopics' => $featuredtopics,
            'cropSetting' => getCropImage('Topics', 'TOPI102')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Topics.TOPI102.create', [
            'cropSetting' => getCropImage('Topics', 'TOPI102')
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

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null, 100);
        if ($path_image_box) $data['path_image_box'] = $path_image_box;

        $path_image_lightbox = $helper->optimizeImage($request, 'path_image_lightbox', $this->path, null, 100);
        if ($path_image_lightbox) $data['path_image_lightbox'] = $path_image_lightbox;

        $path_image_background_lightbox = $helper->optimizeImage($request, 'path_image_background_lightbox', $this->path, null, 100);
        if ($path_image_background_lightbox) $data['path_image_background_lightbox'] = $path_image_background_lightbox;

        if (TOPI102Topics::create($data)) {
            Session::flash('success', 'Tópico cadastrado com sucesso');
            return redirect()->route('admin.topi102.index');
        } else {
            Storage::delete($path_image_box);
            Storage::delete($path_image_lightbox);
            Storage::delete($path_image_background_lightbox);
            Session::flash('error', 'Erro ao cadastradar o tópico');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI102Topics  $TOPI102Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI102Topics $TOPI102Topics)
    {
        return view('Admin.cruds.Topics.TOPI102.edit', [
            'topic' => $TOPI102Topics,
            'cropSetting' => getCropImage('Topics', 'TOPI102')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI102Topics  $TOPI102Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI102Topics $TOPI102Topics)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['link_button'] = isset($data['link_button']) ? getUri($data['link_button']) : null;

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null, 100);
        if ($path_image_box) {
            storageDelete($TOPI102Topics, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if ($request->delete_path_image_box && !$path_image_box) {
            storageDelete($TOPI102Topics, 'path_image_box');
            $data['path_image_box'] = null;
        }

        $path_image_lightbox = $helper->optimizeImage($request, 'path_image_lightbox', $this->path, null, 100);
        if ($path_image_lightbox) {
            storageDelete($TOPI102Topics, 'path_image_lightbox');
            $data['path_image_lightbox'] = $path_image_lightbox;
        }
        if ($request->delete_path_image_lightbox && !$path_image_lightbox) {
            storageDelete($TOPI102Topics, 'path_image_lightbox');
            $data['path_image_lightbox'] = null;
        }

        $path_image_background_lightbox = $helper->optimizeImage($request, 'path_image_background_lightbox', $this->path, null, 100);
        if ($path_image_background_lightbox) {
            storageDelete($TOPI102Topics, 'path_image_background_lightbox');
            $data['path_image_background_lightbox'] = $path_image_background_lightbox;
        }
        if ($request->delete_path_image_background_lightbox && !$path_image_background_lightbox) {
            storageDelete($TOPI102Topics, 'path_image_background_lightbox');
            $data['path_image_background_lightbox'] = null;
        }

        if ($TOPI102Topics->fill($data)->save()) {
            Session::flash('success', 'Tópico atualizado com sucesso');
        } else {
            Storage::delete($path_image_box);
            Storage::delete($path_image_lightbox);
            Storage::delete($path_image_background_lightbox);
            Session::flash('error', 'Erro ao atualizar o tópico');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI102Topics  $TOPI102Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI102Topics $TOPI102Topics)
    {
        storageDelete($TOPI102Topics, 'path_image_box');
        storageDelete($TOPI102Topics, 'path_image_lightbox');
        storageDelete($TOPI102Topics, 'path_image_background_lightbox');

        if ($TOPI102Topics->delete()) {
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
        $TOPI102Topicss = TOPI102Topics::whereIn('id', $request->deleteAll)->get();
        foreach ($TOPI102Topicss as $TOPI102Topics) {
            storageDelete($TOPI102Topics, 'path_image_box');
            storageDelete($TOPI102Topics, 'path_image_lightbox');
            storageDelete($TOPI102Topics, 'path_image_background_lightbox');
        }

        if ($deleted = TOPI102Topics::whereIn('id', $request->deleteAll)->delete()) {
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
            TOPI102Topics::where('id', $id)->update(['sorting' => $sorting]);
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
                $sections = TOPI102TopicsSection::where('path_image_mobile', '!=', '')->active()->first();
                if ($sections) $sections->path_image_desktop = $sections->path_image_mobile;
                break;
            default:
                $sections = TOPI102TopicsSection::active()->first();
                break;
        }

        $topics = TOPI102Topics::active()->sorting()->get();
        $featuredtopics = TOPI102TopicsFeaturedTopics::active()->sorting()->get();
        return view('Client.pages.Topics.TOPI102.section', compact('topics', 'featuredtopics', 'sections'));
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function show()
    {

        return view('Client.pages.Topics.TOPI102.show');
    }
}
