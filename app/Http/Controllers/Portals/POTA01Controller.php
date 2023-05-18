<?php

namespace App\Http\Controllers\Portals;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Portals\POTA01Portals;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Portals\POTA01PortalsSection;
use App\Models\Portals\POTA01PortalsCategory;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portals\POTA01PortalsAdverts;
use App\Models\Portals\POTA01PortalsPodcast;

class POTA01Controller extends Controller
{
    protected $path = 'uploads/Portals/POTA01/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portals = POTA01Portals::with('category')->sorting()->paginate('32');
        $categories = POTA01PortalsCategory::exists()->sorting()->pluck('title', 'id');
        $portalCategories = POTA01PortalsCategory::sorting()->get();
        $section = POTA01PortalsSection::first();

        return view('Admin.cruds.Portals.POTA01.index',[
            'portals' => $portals,
            'categories' => $categories,
            'portalCategories' => $portalCategories,
            'section' => $section,
        ]);
    }

    /**
     * Display a filtered listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        Session::put('filter.category_id', $request->category_id);
        Session::put('filter.title', $request->title);
        Session::put('filter.date_start', $request->date_start);
        Session::put('filter.date_end', $request->date_end);
        Session::put('filter.active', $request->active);
        Session::put('filter.featured_home', $request->featured_home);
        Session::put('filter.featured_page', $request->featured_page);
        Session::save();

        $portals = POTA01Portals::with('category');

        if($request->category_id){
            $portals = $portals->where('category_id', Session::get('filter.category_id'));
        }
        if($request->title){
            $portals = $portals->where('title','LIKE', '%'.Session::get('filter.title').'%');
        }
        if(Session::get('filter.date_start') && Session::get('filter.date_end')){
            $date_start = Carbon::createFromFormat('d/m/Y', Session::get('filter.date_start'))->format('Y-m-d');
            $date_end = Carbon::createFromFormat('d/m/Y', Session::get('filter.date_end'))->format('Y-m-d');
            $portals = $portals->whereBetween('publishing', [$date_start, $date_end]);
        }
        if(Session::get('filter.date_start') && !Session::get('filter.date_end')){
            $date_start = Carbon::createFromFormat('d/m/Y', Session::get('filter.date_start'))->format('Y-m-d');
            $portals = $portals->where('publishing','>=', $date_start);
        }
        if(!Session::get('filter.date_start') && Session::get('filter.date_end')){
            $date_start = Carbon::createFromFormat('d/m/Y', Session::get('filter.date_end'))->format('Y-m-d');
            $portals = $portals->where('publishing','<=', $date_end);
        }
        if(Session::get('filter.active')=='1'){
            $portals = $portals->where('active', 1);
        }
        if(Session::get('filter.active')=='0'){
            $portals = $portals->where('active', 0);
        }
        if(Session::get('filter.featured_home')){
            $portals = $portals->where('featured_home', 1);
        }
        if(Session::get('filter.featured_page')){
            $portals = $portals->where('featured_page', 1);
        }

        $portals = POTA01Portals::with('category')->sorting()->paginate('32');
        $categories = POTA01PortalsCategory::exists()->sorting()->pluck('title', 'id');
        $portalCategories = POTA01PortalsCategory::sorting()->get();
        $section = POTA01PortalsSection::first();

        return view('Admin.cruds.Portals.POTA01.index',[
            'portals' => $portals,
            'categories' => $categories,
            'portalCategories' => $portalCategories,
            'section' => $section,
        ]);
    }

    public function clearFilter()
    {
        Session::forget('filter');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = POTA01PortalsCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Portals.POTA01.create',[
            'categories' => $categories,
            'cropSetting' => getCropImage('Portals', 'POTA01')
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

        $path_image_thumbnail = $helper->optimizeImage($request, 'path_image_thumbnail', $this->path, null,100);
        if($path_image_thumbnail) $data['path_image_thumbnail'] = $path_image_thumbnail;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $data['slug'] = Str::slug($request->title);
        $data['featured_home'] = $request->featured_home?1:0;
        $data['featured_page'] = $request->featured_page?1:0;
        $data['active'] = $request->active?1:0;

        if(POTA01Portals::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
            return redirect()->route('admin.pota01.index');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_thumbnail);
            Session::flash('success', 'Erro ao cadastradar informações');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portals\POTA01Portals  $POTA01Portals
     * @return \Illuminate\Http\Response
     */
    public function edit(POTA01Portals $POTA01Portals)
    {
        $categories = POTA01PortalsCategory::pluck('title', 'id');
        $POTA01Portals->publishing = Carbon::parse($POTA01Portals->publishing)->format('d/m/Y');
        return view('Admin.cruds.Portals.POTA01.edit',[
            'portal' => $POTA01Portals,
            'categories' => $categories,
            'cropSetting' => getCropImage('Portals', 'POTA01')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portals\POTA01Portals  $POTA01Portals
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, POTA01Portals $POTA01Portals)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        // dd($data);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($POTA01Portals, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($POTA01Portals, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_thumbnail = $helper->optimizeImage($request, 'path_image_thumbnail', $this->path, null,100);
        if($path_image_thumbnail){
            storageDelete($POTA01Portals, 'path_image_thumbnail');
            $data['path_image_thumbnail'] = $path_image_thumbnail;
        }
        if($request->delete_path_image_thumbnail && !$path_image_thumbnail){
            storageDelete($POTA01Portals, 'path_image_thumbnail');
            $data['path_image_thumbnail'] = null;
        }

        $data['slug'] = Str::slug($request->title);
        $data['featured_home'] = $request->featured_home?1:0;
        $data['featured_page'] = $request->featured_page?1:0;
        $data['active'] = $request->active?1:0;

        if($POTA01Portals->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_thumbnail);
            Session::flash('success', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portals\POTA01Portals  $POTA01Portals
     * @return \Illuminate\Http\Response
     */
    public function destroy(POTA01Portals $POTA01Portals)
    {
        storageDelete($POTA01Portals, 'path_image');
        storageDelete($POTA01Portals, 'path_image_thumbnail');

        if($POTA01Portals->delete()){
            Session::flash('success', 'Item deletado com sucessso');
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
        $POTA01Portalss = POTA01Portals::whereIn('id', $request->deleteAll)->get();
        foreach($POTA01Portalss as $POTA01Portals){
            storageDelete($POTA01Portals, 'path_image');
            storageDelete($POTA01Portals, 'path_image_thumbnail');
        }

        if($deleted = POTA01Portals::whereIn('id', $request->deleteAll)->delete()){
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
            POTA01Portals::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Portals\POTA01Portals  $POTA01Portals
     * @return \Illuminate\Http\Response
     */

    public function show($POTA01PortalsCategory, POTA01Portals $POTA01Portals)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $portalsRelated = POTA01Portals::with('category')
            ->where('category_id', $POTA01Portals->category_id)
            ->whereNotIn('id', [$POTA01Portals->id])
            ->sorting()
            ->orderBy('featured_home', 'DESC')
            ->orderBy('featured_page', 'DESC')
            ->limit('5')
            ->get();

        $sections = $IncludeSectionsController->IncludeSectionsPage('Portals', 'POTA01', 'show');

        $POTA01Portals->text = conveterOembedCKeditor($POTA01Portals->text);
        $categories = POTA01PortalsCategory::exists()->active()->sorting()->get();
        $categoryCurrent = POTA01PortalsCategory::where('slug', $POTA01PortalsCategory)->first();

        return view('Client.pages.Portals.POTA01.show',[
            'sections' => $sections,
            'portal' => $POTA01Portals,
            'portalsRelated' => $portalsRelated,
            'categories' => $categories,
            'categoryCurrent' => $categoryCurrent,
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \App\Models\Portals\POTA01PortalsCategory  $POTA01PortalsCategory
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, POTA01PortalsCategory $POTA01PortalsCategory)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Portals', 'POTA01', 'page');

        $categories = POTA01PortalsCategory::exists()->active()->sorting()->get();

        $portalsFeatured = POTA01Portals::with('category')->featuredPage();
        $blogFeaturedValidate = POTA01Portals::with('category')->featuredPage();
        $portals = POTA01Portals::with('category');

        $advertsInnerEndPage = null;
        $advertsInnerBeginPage = null;

        if($POTA01PortalsCategory->exists){
            foreach ($categories as $category) {
                if($POTA01PortalsCategory->id==$category->id){
                    $category->selected = true;
                }
            }

            $portalsFeatured = $portalsFeatured->where('category_id', $POTA01PortalsCategory->id);
            $blogFeaturedValidate = $blogFeaturedValidate->where('category_id', $POTA01PortalsCategory->id);
            $portals = $portals->where('category_id', $POTA01PortalsCategory->id);


            $advertsInnerBeginPage = POTA01PortalsAdverts::between()->where('category_id', $POTA01PortalsCategory->id)->where('position', 'categoryInnerBeginPage')->inRandomOrder()->first();
            $advertsInnerEndPage = POTA01PortalsAdverts::between()->where('category_id', $POTA01PortalsCategory->id)->where('position', 'categoryInnerEndPage')->inRandomOrder()->first();
        }

        $portalsFeatured = $portalsFeatured->sorting()->get();
        $blogFeaturedValidate = $blogFeaturedValidate->pluck('id');
        $portals = $portals->whereNotIn('id', $blogFeaturedValidate)->sorting()->paginate('32');

        return view('Client.pages.Portals.POTA01.page',[
            'sections' => $sections,
            'categoryCurrent' => $POTA01PortalsCategory,
            'categories' => $categories,
            'portalsFeatured' => $portalsFeatured,
            'portals' => $portals,
            'advertsInnerBeginPage' => $advertsInnerBeginPage,
            'advertsInnerEndPage' => $advertsInnerEndPage,
        ]);
    }

    public static function viewPageHome()
    {
        $portalsFeatureHome = POTA01Portals::with('category')->featuredHome()->sorting()->get();
        $portalsNotIn = $portalsFeatureHome->pluck('id');
        $portals = POTA01Portals::with('category')->whereNotIn('id' ,$portalsNotIn)->sorting()->orderBy('created_at', 'DESC')->orderBy('updated_at', 'DESC')->get();

        $portalsVideoFeatured = POTA01Portals::with('category')->viewSectionVideo()->featuredPage()->first();
        if(!$portalsVideoFeatured){
            $portalsVideoFeatured = POTA01Portals::with('category')->viewSectionVideo()->first();
        }

        $idVideoFeatured = [$portalsVideoFeatured->id??0];
        $portalsVideo = POTA01Portals::with('category')->whereNotIn('id' ,$idVideoFeatured)->viewSectionVideo()->sorting()->get();
        $categoryVideo = $portalsVideo->first();

        $categories = POTA01PortalsCategory::exists()->sorting()->get();
        $categoriesFeaturedHome = POTA01PortalsCategory::exists()->featuredHome()->sorting()->get();
        foreach ($categoriesFeaturedHome as $categoryFeaturedHome) {
            $categoryFeaturedHome->portals = POTA01Portals::where('category_id', $categoryFeaturedHome->id)->limit(4)->get();
        }
        $podcasts = POTA01PortalsPodcast::active()->featuredHome()->orderBy('created_at', 'DESC')->sorting()->get();

        $advertsBottomPodcast = POTA01PortalsAdverts::between()->where('position', 'homeBottomPodcast')->inRandomOrder()->limit(2)->get();
        $advertsBottomLatestNews = POTA01PortalsAdverts::between()->where('position', 'bottomLatestNews')->inRandomOrder()->first();

        return view('Client.pages.Portals.POTA01.home',[
            'portalsFeatureHome' => $portalsFeatureHome,
            'portals' => $portals,
            'categoryVideo' => $categoryVideo->category,
            'portalsVideoFeatured' => $portalsVideoFeatured,
            'portalsVideo' => $portalsVideo,
            'categories' => $categories,
            'categoriesFeaturedHome' => $categoriesFeaturedHome,
            'podcasts' => $podcasts,
            'advertsBottomPodcast' => $advertsBottomPodcast,
            'advertsBottomLatestNews' => $advertsBottomLatestNews,
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        switch ('home') {
            case 'home':
                return self::viewPageHome();
            break;
            default:
                $portals = POTA01Portals::with('category')->featuredHome()->sorting()->get();
                $section = POTA01PortalsCategory::first();

                $category = POTA01PortalsCategory::first();

                return view('Client.pages.Portals.POTA01.section',[
                    'portals' => $portals,
                    'section' => $section,
                    'category' => $category
                ]);
            break;
        }
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function podcast(Request $request)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Portals', 'POTA01', 'page');
        $portals = POTA01Portals::with('category')->sorting()->orderBy('created_at', 'DESC')->orderBy('updated_at', 'DESC')->limit('5')->get();
        $podcasts = POTA01PortalsPodcast::active()->orderBy('created_at', 'DESC')->sorting()->get();

        $advertsBeforeArticle = POTA01PortalsAdverts::between()->where('position', 'podcastBeforeArticle')->inRandomOrder()->first();
        $advertsAfterArticle = POTA01PortalsAdverts::between()->where('position', 'podcastAfterArticle')->inRandomOrder()->first();

        return view('Client.pages.Portals.POTA01.podcast',[
            'sections' => $sections,
            'portals' => $portals,
            'podcasts' => $podcasts,
            'request' => $request,
            'advertsBeforeArticle' => $advertsBeforeArticle,
            'advertsAfterArticle' => $advertsAfterArticle,
        ]);
    }
}
