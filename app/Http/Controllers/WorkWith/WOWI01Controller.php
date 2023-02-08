<?php

namespace App\Http\Controllers\WorkWith;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WorkWith\WOWI01WorkWith;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\WorkWith\WOWI01WorkWithTopic;
use App\Models\WorkWith\WOWI01WorkWithSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\WorkWith\WOWI01WorkWithTopicSection;

class WOWI01Controller extends Controller
{
    protected $path = 'uploads/WorkWith/WOWI01/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workwiths = WOWI01WorkWith::sorting()->get();
        $section = WOWI01WorkWithSection::first();
        return view('Admin.cruds.WorkWith.WOWI01.index',[
            'workwiths' => $workwiths,
            'section' => $section,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.WorkWith.WOWI01.create',[
            'cropSetting' => getCropImage('WorkWith', 'WOWI01')
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

        $path_image_banner = $helper->optimizeImage($request, 'path_image_banner', $this->path, null, 100);
        if($path_image_banner) $data['path_image_banner'] = $path_image_banner;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_image_thumbnail = $helper->optimizeImage($request, 'path_image_thumbnail', $this->path, null, 100);
        if($path_image_thumbnail) $data['path_image_thumbnail'] = $path_image_thumbnail;

        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null, 100);
        if($path_image_content) $data['path_image_content'] = $path_image_content;

        $data['slug'] = Str::slug($request->title.'-'.$request->subtitle);

        $data['featured_menu'] = $request->featured_menu?1:0;
        $data['active'] = $request->active?1:0;

        if($workwiths = WOWI01WorkWith::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
        }else{
            Storage::delete($path_image_banner);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_thumbnail);
            Storage::delete($path_image_content);

            Session::flash('error', 'Erro ao cadastradar informações');
        }

        return redirect()->route('admin.wowi01.edit', ['WOWI01WorkWith' => $workwiths->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkWith\WOWI01WorkWith  $WOWI01WorkWith
     * @return \Illuminate\Http\Response
     */
    public function edit(WOWI01WorkWith $WOWI01WorkWith)
    {
        $topics = WOWI01WorkWithTopic::where('workwith_id', $WOWI01WorkWith->id)->sorting()->get();
        $topicSection = WOWI01WorkWithTopicSection::where('workwith_id', $WOWI01WorkWith->id)->first();
        return view('Admin.cruds.WorkWith.WOWI01.edit',[
            'workWith' => $WOWI01WorkWith,
            'topicSection' => $topicSection,
            'topics' => $topics,
            'cropSetting' => getCropImage('WorkWith', 'WOWI01')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkWith\WOWI01WorkWith  $WOWI01WorkWith
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WOWI01WorkWith $WOWI01WorkWith)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_banner = $helper->optimizeImage($request, 'path_image_banner', $this->path, null, 100);
        if($path_image_banner){
            storageDelete($WOWI01WorkWith, 'path_image_banner');
            $data['path_image_banner'] = $path_image_banner;
        }
        if($request->delete_path_image_banner && !$path_image_banner){
            storageDelete($WOWI01WorkWith, 'path_image_banner');
            $data['path_image_banner'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon){
            storageDelete($WOWI01WorkWith, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($WOWI01WorkWith, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_image_thumbnail = $helper->optimizeImage($request, 'path_image_thumbnail', $this->path, null, 100);
        if($path_image_thumbnail){
            storageDelete($WOWI01WorkWith, 'path_image_thumbnail');
            $data['path_image_thumbnail'] = $path_image_thumbnail;
        }
        if($request->delete_path_image_thumbnail && !$path_image_thumbnail){
            storageDelete($WOWI01WorkWith, 'path_image_thumbnail');
            $data['path_image_thumbnail'] = null;
        }

        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null, 100);
        if($path_image_content){
            storageDelete($WOWI01WorkWith, 'path_image_content');
            $data['path_image_content'] = $path_image_content;
        }
        if($request->delete_path_image_content && !$path_image_content){
            storageDelete($WOWI01WorkWith, 'path_image_content');
            $data['path_image_content'] = null;
        }

        $data['featured_menu'] = $request->featured_menu?1:0;
        $data['active'] = $request->active?1:0;

        if($WOWI01WorkWith->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image_banner);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_thumbnail);
            Storage::delete($path_image_content);
            Session::flash('error', 'Erro ao atualizar informações');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkWith\WOWI01WorkWith  $WOWI01WorkWith
     * @return \Illuminate\Http\Response
     */
    public function destroy(WOWI01WorkWith $WOWI01WorkWith)
    {
        storageDelete($WOWI01WorkWith, 'path_image_banner');
        storageDelete($WOWI01WorkWith, 'path_image_icon');
        storageDelete($WOWI01WorkWith, 'path_image_thumbnail');
        storageDelete($WOWI01WorkWith, 'path_image_content');

        if($WOWI01WorkWith->delete()){
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
        $WOWI01WorkWiths = WOWI01WorkWith::whereIn('id', $request->deleteAll)->get();
        foreach($WOWI01WorkWiths as $WOWI01WorkWith){
            storageDelete($WOWI01WorkWith, 'path_image_banner');
            storageDelete($WOWI01WorkWith, 'path_image_icon');
            storageDelete($WOWI01WorkWith, 'path_image_thumbnail');
            storageDelete($WOWI01WorkWith, 'path_image_content');
        }

        if($deleted = WOWI01WorkWith::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
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
            WOWI01WorkWith::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\WorkWith\WOWI01WorkWith  $WOWI01WorkWith
     * @return \Illuminate\Http\Response
     */
    public function show(WOWI01WorkWith $WOWI01WorkWith)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('WorkWith', 'WOWI01');

        $section = WOWI01WorkWithSection::first();
        $topics = WOWI01WorkWithTopic::where('workwith_id', $WOWI01WorkWith->id)->active()->sorting()->get();
        $topicSection = WOWI01WorkWithTopicSection::where('workwith_id', $WOWI01WorkWith->id)->active()->first();

        // dd($topicSection);

        $workWiths = WOWI01WorkWith::whereNotIn('id', [$WOWI01WorkWith->id])->active()->sorting()->get();

        return view('Client.pages.WorkWith.WOWI01.show',[
            'workWith' => $WOWI01WorkWith,
            'workWiths' => $workWiths,
            'topicSection' => $topicSection,
            'topics' => $topics,
            'section' => $section,
            'sections' => $sections,
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $workWiths = WOWI01WorkWith::active()->sorting()->get();
        $section = WOWI01WorkWithSection::active()->first();

        return view('Client.pages.WorkWith.WOWI01.section',[
            'workWiths' => $workWiths,
            'section' => $section,
        ]);
    }
}
