<?php

namespace App\Http\Controllers\ContentPages;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\ContentPages\COPA03ContentPages;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA03ContentPagesTopic;
use App\Models\ContentPages\COPA03ContentPagesVideo;
use App\Models\ContentPages\COPA03ContentPagesCategory;
use App\Models\ContentPages\COPA03ContentPagesSubCategoryTopic;
use App\Models\ContentPages\COPA03ContentPagesSubCategoryVideo;

class COPA03Controller extends Controller
{
    protected $path = 'uploads/ContentPages/COPA03/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contentPages = COPA03ContentPages::sorting()->get();
        return view("Admin.cruds.ContentPages.COPA03.index",[
            'contentPages' => $contentPages,
            'cropSetting' => getCropImage('ContentPages', 'COPA03')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Admin.cruds.ContentPages.COPA03.create",[
            'cropSetting' => getCropImage('ContentPages', 'COPA03')
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

        if($request->title_page) $data['slug'] = Str::slug($request->title_page);

        $path_image_banner_desktop = $helper->optimizeImage($request, 'path_image_banner_desktop', $this->path, null,100);
        if($path_image_banner_desktop) $data['path_image_banner_desktop'] = $path_image_banner_desktop;

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null,100);
        if($path_image_banner_mobile) $data['path_image_banner_mobile'] = $path_image_banner_mobile;

        if($contentPage = COPA03ContentPages::create($data)){
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.copa03.edit', ['COPA03ContentPages' => $contentPage->id]);
        }else{
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContentPages\COPA03ContentPages  $COPA03ContentPages
     * @return \Illuminate\Http\Response
     */
    public function edit(COPA03ContentPages $COPA03ContentPages)
    {
        $categories = COPA03ContentPagesCategory::where('contentPage_id', $COPA03ContentPages->id)->sorting()->get();
        $categoriesExists = COPA03ContentPagesCategory::where('contentPage_id', $COPA03ContentPages->id)->sorting()->pluck('title', 'id');
        $categoryIds = $categories->pluck('id');

        $subcategoryTopics = COPA03ContentPagesSubCategoryTopic::whereIn('category_id', $categoryIds)->sorting()->get();
        $subcategoryTopicsExists = COPA03ContentPagesSubCategoryTopic::whereIn('category_id', $categoryIds)->sorting()->pluck('title', 'id');
        $subcategoryTopicsIds = $subcategoryTopics->pluck('id');

        $topics = COPA03ContentPagesTopic::whereIn('subtopic_id', $subcategoryTopicsIds)->sorting()->get();

        $subcategoryVideos = COPA03ContentPagesSubCategoryVideo::whereIn('category_id', $categoryIds)->sorting()->get();
        $subcategoryVideosExists = COPA03ContentPagesSubCategoryVideo::whereIn('category_id', $categoryIds)->sorting()->pluck('title', 'id');
        $subcategoryVideosIds = $subcategoryVideos->pluck('id');

        $videos = COPA03ContentPagesVideo::whereIn('subvideo_id', $subcategoryVideosIds)->sorting()->get();

        return view("Admin.cruds.ContentPages.COPA03.edit",[
            'contentPage' => $COPA03ContentPages,
            'categories' => $categories,
            'categoriesExists' => $categoriesExists,
            'subcategoryTopics' => $subcategoryTopics,
            'subcategoryTopicsExists' => $subcategoryTopicsExists,
            'topics' => $topics,
            'subcategoryVideos' => $subcategoryVideos,
            'subcategoryVideosExists' => $subcategoryVideosExists,
            'videos' => $videos,
            'cropSetting' => getCropImage('ContentPages', 'COPA03')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentPages\COPA03ContentPages  $COPA03ContentPages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COPA03ContentPages $COPA03ContentPages)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;

        if($request->title_page) $data['slug'] = Str::slug($request->title_page);

        $path_image_banner_desktop = $helper->optimizeImage($request, 'path_image_banner_desktop', $this->path, null,100);
        if($path_image_banner_desktop){
            storageDelete($COPA03ContentPages, 'path_image_banner_desktop');
            $data['path_image_banner_desktop'] = $path_image_banner_desktop;
        }
        if($request->delete_path_image_banner_desktop && !$path_image_banner_desktop){
            storageDelete($COPA03ContentPages, 'path_image_banner_desktop');
            $data['path_image_banner_desktop'] = null;
        }

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null,100);
        if($path_image_banner_mobile){
            storageDelete($COPA03ContentPages, 'path_image_banner_mobile');
            $data['path_image_banner_mobile'] = $path_image_banner_mobile;
        }
        if($request->delete_path_image_banner_mobile && !$path_image_banner_mobile){
            storageDelete($COPA03ContentPages, 'path_image_banner_mobile');
            $data['path_image_banner_mobile'] = null;
        }

        if($COPA03ContentPages->fill($data)->save()){
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        }else{
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Session::flash('error', 'Erro ao atualizar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentPages\COPA03ContentPages  $COPA03ContentPages
     * @return \Illuminate\Http\Response
     */
    public function destroy(COPA03ContentPages $COPA03ContentPages)
    {
        storageDelete($COPA03ContentPages, 'path_image_banner_desktop');
        storageDelete($COPA03ContentPages, 'path_image_banner_mobile');

        if($COPA03ContentPages->delete()){
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

        $COPA03ContentPagess = COPA03ContentPages::whereIn('id', $request->deleteAll)->get();
        foreach($COPA03ContentPagess as $COPA03ContentPages){
            storageDelete($COPA03ContentPages, 'path_image_banner_desktop');
            storageDelete($COPA03ContentPages, 'path_image_banner_mobile');
        }

        if($deleted = COPA03ContentPages::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' conteúdos deletados com sucessso']);
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
            COPA03ContentPages::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Contacts\COPA03ContentPages  $COPA03ContentPages
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA03ContentPages $COPA03ContentPages)
    public function show($COPA03ContentPages, COPA03ContentPagesCategory $COPA03ContentPagesCategory, $COPA03ContentPagesSubCategoryT, $COPA03ContentPagesSubCategoryV = null)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('ContentPages', 'COPA03', 'show');

        $COPA03ContentPagesSubCategoryV = COPA03ContentPagesSubCategoryVideo::where('slug', $COPA03ContentPagesSubCategoryV)->exists()->active()->sorting()->first();
        $COPA03ContentPagesSubCategoryT = COPA03ContentPagesSubCategoryTopic::where('slug', $COPA03ContentPagesSubCategoryT)->exists()->active()->sorting()->first();

        $COPA03ContentPages = COPA03ContentPages::where('slug', $COPA03ContentPages)->exists()->active()->sorting()->first();

        if(!$COPA03ContentPages){
            $COPA03ContentPages = COPA03ContentPages::exists()->active()->sorting()->first();
        }

        if(!$COPA03ContentPagesCategory->exists){
            $COPA03ContentPagesCategory = COPA03ContentPagesCategory::where('contentPage_id', $COPA03ContentPages->id)->exists()->sorting()->first();
        }

        if(!$COPA03ContentPagesSubCategoryT){
            $COPA03ContentPagesSubCategoryT = COPA03ContentPagesSubCategoryTopic::with('topics')->where('category_id', $COPA03ContentPagesCategory->id)->exists()->active()->sorting()->first();
        }

        if(!$COPA03ContentPagesSubCategoryV){
            $COPA03ContentPagesSubCategoryV = COPA03ContentPagesSubCategoryVideo::with('videos')->where('category_id', $COPA03ContentPagesCategory->id)->exists()->active()->sorting()->first();
        }

        $categories = COPA03ContentPagesCategory::where('contentPage_id', $COPA03ContentPages->id)->exists()->active()->sorting()->get();

        $subcategoryTopics = COPA03ContentPagesSubCategoryTopic::where('category_id', $COPA03ContentPagesCategory->id)->exists()->active()->sorting()->get();
        $subcategoryVideos = COPA03ContentPagesSubCategoryVideo::where('category_id', $COPA03ContentPagesCategory->id)->exists()->active()->sorting()->get();

        $topics = null;
        $videos = null;

        if($COPA03ContentPagesSubCategoryT) $topics = COPA03ContentPagesTopic::where('subTopic_id', $COPA03ContentPagesSubCategoryT->id)->active()->sorting()->get();
        if($COPA03ContentPagesSubCategoryV) $videos = COPA03ContentPagesVideo::where('subvideo_id', $COPA03ContentPagesSubCategoryV->id)->active()->sorting()->get();

        switch(deviceDetect()){
            case 'mobile':
            case 'tablet':
                if($COPA03ContentPages) $COPA03ContentPages->path_image_banner_desktop = $COPA03ContentPages->path_image_banner_mobile;
            break;
        }

        return view('Client.pages.ContentPages.COPA03.page',[
            'sections' => $sections,
            'contentPage' => $COPA03ContentPages,
            'categories' => $categories,
            'categoryCurrent' => $COPA03ContentPagesCategory,
            'subcategoryTopics' => $subcategoryTopics,
            'subcategoryVideos' => $subcategoryVideos,
            'subcategoryCurrentT' => $COPA03ContentPagesSubCategoryT,
            'subcategoryCurrentV' => $COPA03ContentPagesSubCategoryV,
            'topics' => $topics,
            'videos' => $videos,

        ]);
    }


    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(){

        $COPA03ContentPages = COPA03ContentPages::exists()->active()->sorting()->first();
        $COPA03ContentPagesCategory = COPA03ContentPagesCategory::where('contentPage_id', $COPA03ContentPages->id)->exists()->active()->sorting()->first();

        return Self::show($COPA03ContentPages, $COPA03ContentPagesCategory, null);
    }
}
