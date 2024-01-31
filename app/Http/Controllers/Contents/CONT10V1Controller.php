<?php

namespace App\Http\Controllers\Contents;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contents\CONT10V1Contents;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Contents\CONT10V1ContentsTopic;

class CONT10V1Controller extends Controller
{
    protected $path = 'uploads/Contents/CONT10V1/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT10V1Contents::sorting()->get();
        return view('Admin.cruds.Contents.CONT10V1.index', [
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
        return view('Admin.cruds.Contents.CONT10V1.create',[
            'cropSetting' => getCropImage('Contents', 'CONT10V1')
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

        $data['active'] = $request->active?1:0;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if ($content = CONT10V1Contents::create($data)) {
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.cont10v1.edit', ['CONT10V1Contents' => $content->id]);
        } else {
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contents\CONT10V1Contents  $CONT10V1Contents
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT10V1Contents $CONT10V1Contents)
    {
        $topics = CONT10V1ContentsTopic::where('content_id', $CONT10V1Contents->id)->sorting()->get();

        foreach ($topics as $topic) {
            if($topic) $topic->date = $topic->date != null ? Carbon::parse($topic->date)->format('d/m/Y') : null;
        }

        return view('Admin.cruds.Contents.CONT10V1.edit', [
            'content' => $CONT10V1Contents,
            'topics' => $topics,
            'cropSetting' => getCropImage('Contents', 'CONT10V1')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT10V1Contents  $CONT10V1Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT10V1Contents $CONT10V1Contents)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop){
            storageDelete($CONT10V1Contents, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($CONT10V1Contents, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile){
            storageDelete($CONT10V1Contents, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($CONT10V1Contents, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        if($CONT10V1Contents->fill($data)->save()){
            Session::flash('success', 'Conteúdo atualizada com sucesso');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT10V1Contents  $CONT10V1Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT10V1Contents $CONT10V1Contents)
    {

        if ($CONT10V1Contents->delete()) {
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

        if ($deleted = CONT10V1Contents::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' conteúdos deletados com sucessso']);
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
            CONT10V1Contents::where('id', $id)->update(['sorting' => $sorting]);
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
        $contents = CONT10V1Contents::with('topics')->active()->sorting()->get();

        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                foreach($contents as $content) {
                    if($content) $content->path_image_desktop = $content->path_image_mobile;
                }
            break;
        }

        return view('Client.pages.Contents.CONT10V1.section', [
            'contents' => $contents,
        ]);
    }
}
