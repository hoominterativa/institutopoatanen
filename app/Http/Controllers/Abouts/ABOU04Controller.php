<?php

namespace App\Http\Controllers\Abouts;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Abouts\ABOU04Abouts;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Abouts\ABOU04AboutsTopic;
use Illuminate\Support\Facades\Response;
use App\Models\Abouts\ABOU04AboutsBanner;
use App\Models\Abouts\ABOU04AboutsGallery;
use App\Models\Abouts\ABOU04AboutsSection;
use App\Models\Abouts\ABOU04AboutsCategory;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Abouts\ABOU04AboutsSectionTopic;
use App\Models\Abouts\ABOU04AboutsSectionGallery;
use App\Http\Controllers\IncludeSectionsController;

class ABOU04Controller extends Controller
{
    protected $path = 'uploads/Abouts/ABOU04/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $abouts = ABOU04Abouts::sorting()->get();
        return view('Admin.cruds.Abouts.ABOU04.index', [
            'abouts' => $abouts,
        ]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ABOU04Abouts $ABOU04Abouts)
    {
        return view('Admin.cruds.Abouts.ABOU04.create',[
            'about' => $ABOU04Abouts,
            'cropSetting' => getCropImage('Abouts', 'ABOU04')
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

        $data['active_banner'] = $request->active_banner?1:0;
        $data['active_topics'] = $request->active_topics?1:0;
        $data['active_galleries'] = $request->active_galleries?1:0;
        $data['link_button_galleries'] = isset($data['link_button_galleries']) ? getUri($data['link_button_galleries']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

         //Banner
         $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
         if($path_image_desktop_banner) $data['path_image_desktop_banner'] = $path_image_desktop_banner;

         $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
         if($path_image_mobile_banner) $data['path_image_mobile_banner'] = $path_image_mobile_banner;

         // Section topics
         $path_image_desktop_topics = $helper->optimizeImage($request, 'path_image_desktop_topics', $this->path, null,100);
         if($path_image_desktop_topics) $data['path_image_desktop_topics'] = $path_image_desktop_topics;

         $path_image_mobile_topics = $helper->optimizeImage($request, 'path_image_mobile_topics', $this->path, null,100);
         if($path_image_mobile_topics) $data['path_image_mobile_topics'] = $path_image_mobile_topics;

        if($about = ABOU04Abouts::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
            return redirect()->route('admin.abou04.edit', ['ABOU04Abouts' => $about->id]);
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Storage::delete($path_image_desktop_topics);
            Storage::delete($path_image_mobile_topics);
            Session::flash('error', 'Erro ao cadastradar as informações');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blogs\BLOG03Blogs  $BLOG03Blogs
     * @return \Illuminate\Http\Response
     */
    public function edit(ABOU04Abouts $ABOU04Abouts)
    {
        $topics = ABOU04AboutsTopic::where('about_id', $ABOU04Abouts->id)->sorting()->get();
        $galleries = ABOU04AboutsGallery::where('about_id', $ABOU04Abouts->id)->with('category')->sorting()->get();
        $categories = ABOU04AboutsCategory::where('about_id', $ABOU04Abouts->id)->exists()->sorting()->pluck('title', 'id');
        $categoryCreate = ABOU04AboutsCategory::where('about_id', $ABOU04Abouts->id)->sorting()->pluck('title', 'id');
        $galleryCategories = ABOU04AboutsCategory::where('about_id', $ABOU04Abouts->id)->sorting()->get();

        return view('Admin.cruds.Abouts.ABOU04.edit',[
            'about' => $ABOU04Abouts,
            'topics' => $topics,
            'galleries' => $galleries,
            'categories' => $categories,
            'galleryCategories' => $galleryCategories,
            'categoryCreate' => $categoryCreate,
            'cropSetting' => getCropImage('Abouts', 'ABOU04')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abouts\ABOU04Abouts  $ABOU04Abouts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU04Abouts $ABOU04Abouts)
    {
        $data = $request->all();
        $helper = new HelperArchive();
        $data['active'] = $request->active?1:0;
        if($request->title || $request->subtitle) $data['slug'] = Str::slug($request->title . ' ' . ($request->subtitle ? $request->subtitle : ''));

        $data['active_banner'] = $request->active_banner?1:0;
        $data['active_topics'] = $request->active_topics?1:0;
        $data['active_galleries'] = $request->active_galleries?1:0;
        $data['link_button_galleries'] = isset($data['link_button_galleries']) ? getUri($data['link_button_galleries']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($ABOU04Abouts, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($ABOU04Abouts, 'path_image');
            $data['path_image'] = null;
        }

        //Banner
        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner){
            storageDelete($ABOU04Abouts, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if($request->delete_path_image_desktop_banner && !$path_image_desktop_banner){
            storageDelete($ABOU04Abouts, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner){
            storageDelete($ABOU04Abouts, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if($request->delete_path_image_mobile_banner && !$path_image_mobile_banner){
            storageDelete($ABOU04Abouts, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }

        //Section Topics
        $path_image_desktop_topics = $helper->optimizeImage($request, 'path_image_desktop_topics', $this->path, null,100);
        if($path_image_desktop_topics){
            storageDelete($ABOU04Abouts, 'path_image_desktop_topics');
            $data['path_image_desktop_topics'] = $path_image_desktop_topics;
        }
        if($request->delete_path_image_desktop_topics && !$path_image_desktop_topics){
            storageDelete($ABOU04Abouts, 'path_image_desktop_topics');
            $data['path_image_desktop_topics'] = null;
        }

        $path_image_mobile_topics = $helper->optimizeImage($request, 'path_image_mobile_topics', $this->path, null,100);
        if($path_image_mobile_topics){
            storageDelete($ABOU04Abouts, 'path_image_mobile_topics');
            $data['path_image_mobile_topics'] = $path_image_mobile_topics;
        }
        if($request->delete_path_image_mobile_topics && !$path_image_mobile_topics){
            storageDelete($ABOU04Abouts, 'path_image_mobile_topics');
            $data['path_image_mobile_topics'] = null;
        }

        if($ABOU04Abouts->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Storage::delete($path_image_desktop_topics);
            Storage::delete($path_image_mobile_topics);
            Session::flash('error', 'Erro ao atualizar as informações');
        }
        return redirect()->back();
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Abouts\ABOU04AboutsTopic  $ABOU04AboutsTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(ABOU04Abouts $ABOU04Abouts)
    {
        $topics = ABOU04AboutsTopic::where('about_id', $ABOU04Abouts->id)->get();
            if ($topics->count()) {
                foreach ($topics as $topic) {
                    storageDelete($topic, 'path_image_icon');
                    $topic->delete();
                }
            }

        $galleries = ABOU04AboutsGallery::where('about_id', $ABOU04Abouts->id)->get();
        if ($galleries->count()) {
            foreach ($galleries as $gallery) {
                storageDelete($gallery, 'path_image');
                $gallery->delete();
            }
        }

        $categories = ABOU04AboutsCategory::where('about_id', $ABOU04Abouts->id)->get();
        if ($categories->count()) {
            foreach ($categories as $category) {
                $category->delete();
            }
        }

        storageDelete($ABOU04Abouts, 'path_image');
        storageDelete($ABOU04Abouts, 'path_image_desktop_banner');
        storageDelete($ABOU04Abouts, 'path_image_mobile_banner');
        storageDelete($ABOU04Abouts, 'path_image_desktop_topics');
        storageDelete($ABOU04Abouts, 'path_image_mobile_topics');

        if($ABOU04Abouts->delete()){
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

        $ABOU04Abouts = ABOU04Abouts::whereIn('id', $request->deleteAll)->get();
        foreach($ABOU04Abouts as $ABOU04Abouts){
            $topics = ABOU04AboutsTopic::where('about_id', $ABOU04Abouts->id)->get();
            if ($topics->count()) {
                foreach ($topics as $topic) {
                    storageDelete($topic, 'path_image_icon');
                    $topic->delete();
                }
            }

            $galleries = ABOU04AboutsGallery::where('about_id', $ABOU04Abouts->id)->get();
            if ($galleries->count()) {
                foreach ($galleries as $gallery) {
                    storageDelete($gallery, 'path_image');
                    $gallery->delete();
                }
            }

            $categories = ABOU04AboutsCategory::where('about_id', $ABOU04Abouts->id)->get();
            if ($categories->count()) {
                foreach ($categories as $category) {
                    $category->delete();
                }
            }

            storageDelete($ABOU04Abouts, 'path_image');
            storageDelete($ABOU04Abouts, 'path_image_desktop_banner');
            storageDelete($ABOU04Abouts, 'path_image_mobile_banner');
            storageDelete($ABOU04Abouts, 'path_image_desktop_topics');
            storageDelete($ABOU04Abouts, 'path_image_mobile_topics');
        }

        if($deleted = ABOU04Abouts::whereIn('id', $request->deleteAll)->delete()){
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
            ABOU04Abouts::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Abouts\ABOU04Abouts  $ABOU04Abouts
     * @return \Illuminate\Http\Response
     */
    //public function show(ABOU04Abouts $ABOU04Abouts)
    public function show(Request $request, ABOU04Abouts $ABOU04Abouts)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Abouts', 'ABOU04', 'show');

        $categories = ABOU04AboutsCategory::with(['galleries' => function ($query) {$query->where('active', 1);}])->where('about_id', $ABOU04Abouts->id)->exists()->active()->sorting()->get();
        $topics = ABOU04AboutsTopic::where('about_id', $ABOU04Abouts->id)->active()->sorting()->get();
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($ABOU04Abouts)
                $ABOU04Abouts->path_image_desktop_banner = $ABOU04Abouts->path_image_mobile_banner;
                $ABOU04Abouts->path_image_desktop_topics = $ABOU04Abouts->path_image_mobile_topics;
            break;

        }

        return view('Client.pages.Abouts.ABOU04.page',[
            'sections' => $sections,
            'about' => $ABOU04Abouts,
            'topics' => $topics,
            'categories' => $categories
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, ABOU04Abouts $ABOU04Abouts)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Abouts', 'ABOU04', 'page');

        $about = ABOU04Abouts::active()->sorting()->first();
        $categories = ABOU04AboutsCategory::with(['galleries' => function ($query) {$query->where('active', 1);}])->where('about_id', $about->id)->exists()->active()->sorting()->get();
        $topics = ABOU04AboutsTopic::where('about_id', $about->id)->active()->sorting()->get();
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($about)
                $about->path_image_desktop_banner = $about->path_image_mobile_banner;
                $about->path_image_desktop_topics = $about->path_image_mobile_topics;
            break;

        }

        return view('Client.pages.Abouts.ABOU04.page',[
            'sections' => $sections,
            'about' => $about,
            'categories' => $categories,
            'topics' => $topics,

        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        return view('Client.pages.Abouts.ABOU04.section');
    }
}
