<?php

namespace App\Http\Controllers\Contents;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contents\CONT10Contents;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Contents\CONT10ContentsSection;
use App\Models\Contents\CONT10ContentsTopic;

class CONT10Controller extends Controller
{
    protected $path = 'uploads/Contents/CONT10/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT10Contents::sorting()->get();
        return view('Admin.cruds.Contents.CONT10.index', [
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
        return view('Admin.cruds.Contents.CONT10.create',[
            'cropSetting' => getCropImage('Contents', 'CONT10')
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

        if ($content = CONT10Contents::create($data)) {
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.cont10.edit', ['CONT10Contents' => $content->id]);
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
     * @param  \App\Models\Contents\CONT10Contents  $CONT10Contents
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT10Contents $CONT10Contents)
    {
        $topics = CONT10ContentsTopic::where('content_id', $CONT10Contents->id)->sorting()->get();

        foreach ($topics as $topic) {
            if($topic) $topic->date = $topic->date != null ? Carbon::parse($topic->date)->format('d/m/Y') : null;
        }

        return view('Admin.cruds.Contents.CONT10.edit', [
            'content' => $CONT10Contents,
            'topics' => $topics,
            'cropSetting' => getCropImage('Contents', 'CONT10')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT10Contents  $CONT10Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT10Contents $CONT10Contents)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop){
            storageDelete($CONT10Contents, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($CONT10Contents, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile){
            storageDelete($CONT10Contents, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($CONT10Contents, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        if($CONT10Contents->fill($data)->save()){
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
     * @param  \App\Models\Contents\CONT10Contents  $CONT10Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT10Contents $CONT10Contents)
    {

        if ($CONT10Contents->delete()) {
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

        if ($deleted = CONT10Contents::whereIn('id', $request->deleteAll)->delete()) {
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
            CONT10Contents::where('id', $id)->update(['sorting' => $sorting]);
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
        $contents = CONT10Contents::with('topics')->active()->sorting()->get();

        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                foreach($contents as $content) {
                    if($content) $content->path_image_desktop = $content->path_image_mobile;
                }
            break;
        }

        return view('Client.pages.Contents.CONT10.section', [
            'contents' => $contents,
        ]);
    }
}
