<?php

namespace App\Http\Controllers\Abouts;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Abouts\ABOU01Abouts;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Abouts\ABOU01AboutsTopics;
use App\Models\Abouts\ABOU01AboutsSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class ABOU01Controller extends Controller
{
    protected $path = 'uploads/Abouts/ABOU01/images/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $abouts = ABOU01Abouts::sorting()->get();
        return view('Admin.cruds.Abouts.ABOU01.index',[
            'abouts' => $abouts,
            'cropSetting' => getCropImage('Abouts', 'ABOU01')
        ]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ABOU01Abouts $ABOU01Abouts)
    {
        return view('Admin.cruds.Abouts.ABOU01.create',[
            'about' => $ABOU01Abouts,
            'cropSetting' => getCropImage('Abouts', 'ABOU01')
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
        if($request->title || $request->subtitle) $data['slug'] = Str::slug($request->title . ' ' . ($request->subtitle ? $request->subtitle : ''));

        $data['active_section'] = $request->active_section?1:0;
        $data['active_banner'] = $request->active_banner?1:0;
        $data['active_content'] = $request->active_content?1:0;
        $data['link_button_content'] = isset($data['link_button_content']) ? getUri($data['link_button_content']) : null;

        //Abouts
        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if($path_image) $data['path_image'] = $path_image;

        //Others
        $path_image_banner_desktop = $helper->optimizeImage($request, 'path_image_banner_desktop', $this->path, null, 100);
        if($path_image_banner_desktop) $data['path_image_banner_desktop'] = $path_image_banner_desktop;

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null, 100);
        if($path_image_banner_mobile) $data['path_image_banner_mobile'] = $path_image_banner_mobile;

        $path_image_content_desktop = $helper->optimizeImage($request, 'path_image_content_desktop', $this->path, null, 100);
        if($path_image_content_desktop) $data['path_image_content_desktop'] = $path_image_content_desktop;

        $path_image_content_mobile = $helper->optimizeImage($request, 'path_image_content_mobile', $this->path, null, 100);
        if($path_image_content_mobile) $data['path_image_content_mobile'] = $path_image_content_mobile;

        $path_image_section_desktop = $helper->optimizeImage($request, 'path_image_section_desktop', $this->path, null, 100);
        if($path_image_section_desktop) $data['path_image_section_desktop'] = $path_image_section_desktop;

        $path_image_section_mobile = $helper->optimizeImage($request, 'path_image_section_mobile', $this->path, null, 100);
        if($path_image_section_mobile) $data['path_image_section_mobile'] = $path_image_section_mobile;

        $path_image_topic_desktop = $helper->optimizeImage($request, 'path_image_topic_desktop', $this->path, null, 100);
        if($path_image_topic_desktop) $data['path_image_topic_desktop'] = $path_image_topic_desktop;

        $path_image_topic_mobile = $helper->optimizeImage($request, 'path_image_topic_mobile', $this->path, null, 100);
        if($path_image_topic_mobile) $data['path_image_topic_mobile'] = $path_image_topic_mobile;

        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null, 100);
        if($path_image_content) $data['path_image_content'] = $path_image_content;

        if($about = ABOU01Abouts::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
            return redirect()->route('admin.abou01.edit', ['ABOU01Abouts' => $about->id]);
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Storage::delete($path_image);
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Storage::delete($path_image_section_desktop);
            Storage::delete($path_image_section_mobile);
            Storage::delete($path_image_topic_desktop);
            Storage::delete($path_image_topic_mobile);
            Storage::delete($path_image_content_desktop);
            Storage::delete($path_image_content_mobile);
            Storage::delete($path_image_content);
            Session::flash('success', 'Erro ao cadastradar as informações');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blogs\BLOG03Blogs  $BLOG03Blogs
     * @return \Illuminate\Http\Response
     */
    public function edit(ABOU01Abouts $ABOU01Abouts)
    {
        $topics = ABOU01AboutsTopics::where('about_id', $ABOU01Abouts->id)->sorting()->get();
        return view('Admin.cruds.Abouts.ABOU01.edit',[
            'about' => $ABOU01Abouts,
            'topics' => $topics,
            'cropSetting' => getCropImage('Abouts', 'ABOU01')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abouts\ABOU01Abouts  $ABOU01Abouts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU01Abouts $ABOU01Abouts)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        if($request->title || $request->subtitle) $data['slug'] = Str::slug($request->title . ' ' . ($request->subtitle ? $request->subtitle : ''));

        $data['active_section'] = $request->active_section?1:0;
        $data['active_banner'] = $request->active_banner?1:0;
        $data['active_content'] = $request->active_content?1:0;
        $data['link_button_content'] = isset($data['link_button_content']) ? getUri($data['link_button_content']) : null;

        // path_image_desktop
        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null, 100);
        if($path_image_desktop){
            storageDelete($ABOU01Abouts, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($ABOU01Abouts, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        // path_image_mobile
        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null, 100);
        if($path_image_mobile){
            storageDelete($ABOU01Abouts, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($ABOU01Abouts, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        // path_image
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if($path_image){
            storageDelete($ABOU01Abouts, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($ABOU01Abouts, 'path_image');
            $data['path_image'] = null;
        }

        //Others
        $path_image_banner_desktop = $helper->optimizeImage($request, 'path_image_banner_desktop', $this->path, null, 100);
        if($path_image_banner_desktop){
            storageDelete($ABOU01Abouts, 'path_image_banner_desktop');
            $data['path_image_banner_desktop'] = $path_image_banner_desktop;
        }
        if($request->delete_path_image_banner_desktop && !$path_image_banner_desktop){
            storageDelete($ABOU01Abouts, 'path_image_banner_desktop');
            $data['path_image_banner_desktop'] = null;
        }

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null, 100);
        if($path_image_banner_mobile){
            storageDelete($ABOU01Abouts, 'path_image_banner_mobile');
            $data['path_image_banner_mobile'] = $path_image_banner_mobile;
        }
        if($request->delete_path_image_banner_mobile && !$path_image_banner_mobile){
            storageDelete($ABOU01Abouts, 'path_image_banner_mobile');
            $data['path_image_banner_mobile'] = null;
        }

        $path_image_content_desktop = $helper->optimizeImage($request, 'path_image_content_desktop', $this->path, null, 100);
        if($path_image_content_desktop){
            storageDelete($ABOU01Abouts, 'path_image_content_desktop');
            $data['path_image_content_desktop'] = $path_image_content_desktop;
        }
        if($request->delete_path_image_content_desktop && !$path_image_content_desktop){
            storageDelete($ABOU01Abouts, 'path_image_content_desktop');
            $data['path_image_content_desktop'] = null;
        }

        $path_image_content_mobile = $helper->optimizeImage($request, 'path_image_content_mobile', $this->path, null, 100);
        if($path_image_content_mobile){
            storageDelete($ABOU01Abouts, 'path_image_content_mobile');
            $data['path_image_content_mobile'] = $path_image_content_mobile;
        }
        if($request->delete_path_image_content_mobile && !$path_image_content_mobile){
            storageDelete($ABOU01Abouts, 'path_image_content_mobile');
            $data['path_image_content_mobile'] = null;
        }

        $path_image_section_desktop = $helper->optimizeImage($request, 'path_image_section_desktop', $this->path, null, 100);
        if($path_image_section_desktop){
            storageDelete($ABOU01Abouts, 'path_image_section_desktop');
            $data['path_image_section_desktop'] = $path_image_section_desktop;
        }
        if($request->delete_path_image_section_desktop && !$path_image_section_desktop){
            storageDelete($ABOU01Abouts, 'path_image_section_desktop');
            $data['path_image_section_desktop'] = null;
        }

        $path_image_section_mobile = $helper->optimizeImage($request, 'path_image_section_mobile', $this->path, null, 100);
        if($path_image_section_mobile){
            storageDelete($ABOU01Abouts, 'path_image_section_mobile');
            $data['path_image_section_mobile'] = $path_image_section_mobile;
        }
        if($request->delete_path_image_section_mobile && !$path_image_section_mobile){
            storageDelete($ABOU01Abouts, 'path_image_section_mobile');
            $data['path_image_section_mobile'] = null;
        }

        $path_image_topic_desktop = $helper->optimizeImage($request, 'path_image_topic_desktop', $this->path, null, 100);
        if($path_image_topic_desktop){
            storageDelete($ABOU01Abouts, 'path_image_topic_desktop');
            $data['path_image_topic_desktop'] = $path_image_topic_desktop;
        }
        if($request->delete_path_image_topic_desktop && !$path_image_topic_desktop){
            storageDelete($ABOU01Abouts, 'path_image_topic_desktop');
            $data['path_image_topic_desktop'] = null;
        }

        $path_image_topic_mobile = $helper->optimizeImage($request, 'path_image_topic_mobile', $this->path, null, 100);
        if($path_image_topic_mobile){
            storageDelete($ABOU01Abouts, 'path_image_topic_mobile');
            $data['path_image_topic_mobile'] = $path_image_topic_mobile;
        }
        if($request->delete_path_image_topic_mobile && !$path_image_topic_mobile){
            storageDelete($ABOU01Abouts, 'path_image_topic_mobile');
            $data['path_image_topic_mobile'] = null;
        }

        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null, 100);
        if($path_image_content){
            storageDelete($ABOU01Abouts, 'path_image_content');
            $data['path_image_content'] = $path_image_content;
        }
        if($request->delete_path_image_content && !$path_image_content){
            storageDelete($ABOU01Abouts, 'path_image_content');
            $data['path_image_content'] = null;
        }

        if($ABOU01Abouts->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Storage::delete($path_image);
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Storage::delete($path_image_section_desktop);
            Storage::delete($path_image_section_mobile);
            Storage::delete($path_image_topic_desktop);
            Storage::delete($path_image_topic_mobile);
            Storage::delete($path_image_content_desktop);
            Storage::delete($path_image_content_mobile);
            Storage::delete($path_image_content);
            Session::flash('success', 'Erro ao atualizar as informações');
        }
        return redirect()->back();
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Abouts\ABOU01AboutsTopic  $ABOU01AboutsTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(ABOU01Abouts $ABOU01Abouts)
    {

        storageDelete($ABOU01Abouts, 'path_image');
        storageDelete($ABOU01Abouts, 'path_image_desktop');
        storageDelete($ABOU01Abouts, 'path_image_mobile');
        storageDelete($ABOU01Abouts, 'path_image_banner_mobile');
        storageDelete($ABOU01Abouts, 'path_image_banner_desktop');
        storageDelete($ABOU01Abouts, 'path_image_section_desktop');
        storageDelete($ABOU01Abouts, 'path_image_section_mobile');
        storageDelete($ABOU01Abouts, 'path_image_topic_desktop');
        storageDelete($ABOU01Abouts, 'path_image_topic_mobile');
        storageDelete($ABOU01Abouts, 'path_image_content_desktop');
        storageDelete($ABOU01Abouts, 'path_image_content_mobile');
        storageDelete($ABOU01Abouts, 'path_image_content');

        if($ABOU01Abouts->delete()){
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

        $ABOU01Abouts = ABOU01Abouts::whereIn('id', $request->deleteAll)->get();
        foreach($ABOU01Abouts as $ABOU01Abouts){


            storageDelete($ABOU01Abouts, 'path_image');
            storageDelete($ABOU01Abouts, 'path_image_desktop');
            storageDelete($ABOU01Abouts, 'path_image_mobile');
            storageDelete($ABOU01Abouts, 'path_image_banner_mobile');
            storageDelete($ABOU01Abouts, 'path_image_banner_desktop');
            storageDelete($ABOU01Abouts, 'path_image_section_desktop');
            storageDelete($ABOU01Abouts, 'path_image_section_mobile');
            storageDelete($ABOU01Abouts, 'path_image_topic_desktop');
            storageDelete($ABOU01Abouts, 'path_image_topic_mobile');
            storageDelete($ABOU01Abouts, 'path_image_content_desktop');
            storageDelete($ABOU01Abouts, 'path_image_content_mobile');
            storageDelete($ABOU01Abouts, 'path_image_content');
        }

        if($deleted = ABOU01Abouts::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Conteúdo deletados com sucessso']);
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
            ABOU01Abouts::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Abouts\ABOU01Abouts  $ABOU01Abouts
     * @return \Illuminate\Http\Response
     */
    //public function show(ABOU01Abouts $ABOU01Abouts)
    public function show(Request $request, ABOU01Abouts $ABOU01Abouts)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Abouts', 'ABOU01', 'show');

        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($ABOU01Abouts)
                $ABOU01Abouts->path_image_desktop = $ABOU01Abouts->path_image_mobile;
                $ABOU01Abouts->path_image_banner_desktop = $ABOU01Abouts->path_image_banner_mobile;
                $ABOU01Abouts->path_image_topic_desktop = $ABOU01Abouts->path_image_topic_mobile;
                $ABOU01Abouts->path_image_content_desktop = $ABOU01Abouts->path_image_content_mobile;
            break;

        }

        return view('Client.pages.Abouts.ABOU01.page',[
            'sections' => $sections,
            'about' => $ABOU01Abouts,
        ]);
    }

     /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Abouts', 'ABOU01');

        $about = ABOU01Abouts::with('topics')->active()->sorting()->first();

        switch (deviceDetect()) {
            case "mobile":
            case "tablet":
                if($about)
                $about->path_image_desktop = $about->path_image_mobile;
                $about->path_image_banner_desktop = $about->path_image_banner_mobile;
                $about->path_image_topic_desktop = $about->path_image_topic_mobile;
                $about->path_image_content_desktop = $about->path_image_content_mobile;
            break;
        }

        return view('Client.pages.Abouts.ABOU01.page',[
            'sections' => $sections,
            'about' => $about,
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $section = ABOU01Abouts::activeSection()->first();
        switch(deviceDetect()){
            case "mobile":
            case "tablet":
                if($section) $section->path_image_section_desktop = $section->path_image_section_mobile;
            break;
        }

        return view('Client.pages.Abouts.ABOU01.section',[
            'section' => $section
        ]);
    }
}
