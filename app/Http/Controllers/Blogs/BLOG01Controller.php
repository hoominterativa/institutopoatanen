<?php

namespace App\Http\Controllers\Blogs;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Blogs\BLOG01Blogs;
use Cohensive\Embed\Facades\Embed;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Blogs\BLOG01BlogsSection;
use Illuminate\Support\Facades\Response;
use App\Models\Blogs\BLOG01BlogsCategory;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class BLOG01Controller extends Controller
{
    protected $path = 'uploads/Blogs/BLOG01/images/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blogs = BLOG01Blogs::with('category')->sorting()->paginate('32');
        $categories = BLOG01BlogsCategory::exists()->sorting()->pluck('title', 'id');
        $blogCategories = BLOG01BlogsCategory::sorting()->get();
        $section = BLOG01BlogsSection::first();

        return view('Admin.cruds.Blogs.BLOG01.index',[
            'blogs' => $blogs,
            'categories' => $categories,
            'blogCategories' => $blogCategories,
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

        $blogs = BLOG01Blogs::with('category');

        if($request->category_id){
            $blogs = $blogs->where('category_id', Session::get('filter.category_id'));
        }
        if($request->title){
            $blogs = $blogs->where('title','LIKE', '%'.Session::get('filter.title').'%');
        }
        if(Session::get('filter.date_start') && Session::get('filter.date_end')){
            $request->date_start = Carbon::createFromFormat('d/m/Y', Session::get('filter.date_start'))->format('Y-m-d');
            $request->date_end = Carbon::createFromFormat('d/m/Y', Session::get('filter.date_end'))->format('Y-m-d');
            $blogs = $blogs->whereBetween('publishing', [$request->date_start, $request->date_end]);
        }
        if(Session::get('filter.date_start') && !Session::get('filter.date_end')){
            $request->date_start = Carbon::createFromFormat('d/m/Y', Session::get('filter.date_start'))->format('Y-m-d');
            $blogs = $blogs->where('publishing','>=', $request->date_start);
        }
        if(!Session::get('filter.date_start') && Session::get('filter.date_end')){
            $request->date_start = Carbon::createFromFormat('d/m/Y', Session::get('filter.date_end'))->format('Y-m-d');
            $blogs = $blogs->where('publishing','<=', $request->date_end);
        }
        if(Session::get('filter.active')=='1'){
            $blogs = $blogs->where('active', 1);
        }
        if(Session::get('filter.active')=='0'){
            $blogs = $blogs->where('active', 0);
        }
        if(Session::get('filter.featured_home')){
            $blogs = $blogs->where('featured_home', 1);
        }
        if(Session::get('filter.featured_page')){
            $blogs = $blogs->where('featured_page', 1);
        }

        $blogs = BLOG01Blogs::with('category')->sorting()->paginate('32');
        $categories = BLOG01BlogsCategory::exists()->sorting()->pluck('title', 'id');
        $blogCategories = BLOG01BlogsCategory::sorting()->get();
        $section = BLOG01BlogsSection::first();

        return view('Admin.cruds.Blogs.BLOG01.index',[
            'blogs' => $blogs,
            'categories' => $categories,
            'blogCategories' => $blogCategories,
            'section' => $section,
        ]);
    }

    public function clearFilter()
    {
        Session::forget('filter');
        return redirect()->route('admin.blog01.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = BLOG01BlogsCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Blogs.BLOG01.create',[
            'categories' => $categories,
            'cropSetting' => getCropImage('Blogs', 'BLOG01')
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

        if(BLOG01Blogs::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
            return redirect()->route('admin.blog01.index');
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
     * @param  \App\Models\Blogs\BLOG01Blogs  $BLOG01Blogs
     * @return \Illuminate\Http\Response
     */
    public function edit(BLOG01Blogs $BLOG01Blogs)
    {
        $categories = BLOG01BlogsCategory::pluck('title', 'id');
        $BLOG01Blogs->publishing = Carbon::parse($BLOG01Blogs->publishing)->format('d/m/Y');
        return view('Admin.cruds.Blogs.BLOG01.edit',[
            'blog' => $BLOG01Blogs,
            'categories' => $categories,
            'cropSetting' => getCropImage('Blogs', 'BLOG01')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blogs\BLOG01Blogs  $BLOG01Blogs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BLOG01Blogs $BLOG01Blogs)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($BLOG01Blogs, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($BLOG01Blogs, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_thumbnail = $helper->optimizeImage($request, 'path_image_thumbnail', $this->path, null,100);
        if($path_image_thumbnail){
            storageDelete($BLOG01Blogs, 'path_image_thumbnail');
            $data['path_image_thumbnail'] = $path_image_thumbnail;
        }
        if($request->delete_path_image_thumbnail && !$path_image_thumbnail){
            storageDelete($BLOG01Blogs, 'path_image_thumbnail');
            $data['path_image_thumbnail'] = null;
        }

        $data['slug'] = Str::slug($request->title);
        $data['featured_home'] = $request->featured_home?1:0;
        $data['featured_page'] = $request->featured_page?1:0;
        $data['active'] = $request->active?1:0;

        if($BLOG01Blogs->fill($data)->save()){
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
     * @param  \App\Models\Blogs\BLOG01Blogs  $BLOG01Blogs
     * @return \Illuminate\Http\Response
     */
    public function destroy(BLOG01Blogs $BLOG01Blogs)
    {
        storageDelete($BLOG01Blogs, 'path_image');
        storageDelete($BLOG01Blogs, 'path_image_thumbnail');

        if($BLOG01Blogs->delete()){
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
        $BLOG01Blogss = BLOG01Blogs::whereNotIn('id', $request->deleteAll)->get();
        foreach($BLOG01Blogss as $BLOG01Blogs){
            storageDelete($BLOG01Blogs, 'path_image');
            storageDelete($BLOG01Blogs, 'path_image_thumbnail');
        }

        if($deleted = BLOG01Blogs::whereNotIn('id', $request->deleteAll)->delete()){
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
            BLOG01Blogs::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Blogs\BLOG01BlogsCategory  $BLOG01BlogsCategory
     * @param  \App\Models\Blogs\BLOG01Blogs  $BLOG01Blogs
     * @return \Illuminate\Http\Response
     */
    public function show($BLOG01BlogsCategory, BLOG01Blogs $BLOG01Blogs)
    {
        $blogsRelated = BLOG01Blogs::with('category')
            ->where('category_id', $BLOG01Blogs->category_id)
            ->whereNotIn('id', [$BLOG01Blogs->id])
            ->sorting()
            ->orderBy('featured_home', 'DESC')
            ->orderBy('featured_page', 'DESC')
            ->limit('5')
            ->get();

        $BLOG01Blogs->text = conveterOembedCKeditor($BLOG01Blogs->text);

        return view('Client.pages.Blogs.BLOG01.show',[
            'blog' => $BLOG01Blogs,
            'blogsRelated' => $blogsRelated,
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, BLOG01BlogsCategory $BLOG01Category)
    {

        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Blogs', 'BLOG01');

        $categories = BLOG01BlogsCategory::exists()->active()->sorting()->get();

        $blogsFeatured = BLOG01Blogs::with('category')->featuredPage();
        $blogFeaturedValidate = BLOG01Blogs::with('category')->featuredPage();
        $blogs = BLOG01Blogs::with('category');

        if($BLOG01Category->exists){
            foreach ($categories as $category) {
                if($BLOG01Category->id==$category->id){
                    $category->selected = true;
                }
            }

            $blogsFeatured = $blogsFeatured->where('category_id', $BLOG01Category->id);
            $blogFeaturedValidate = $blogFeaturedValidate->where('category_id', $BLOG01Category->id);
            $blogs = $blogs->where('category_id', $BLOG01Category->id);
        }

        $blogsFeatured = $blogsFeatured->sorting()->get();
        $blogFeaturedValidate = $blogFeaturedValidate->pluck('id');
        $blogs = $blogs->whereNotIn('id', $blogFeaturedValidate)->sorting()->paginate('32');

        return view('Client.pages.Blogs.BLOG01.page',[
            'sections' => $sections,
            'categories' => $categories,
            'blogsFeatured' => $blogsFeatured,
            'blogs' => $blogs,
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $blogs = BLOG01Blogs::with('category')->featuredHome()->sorting()->get();
        $section = BLOG01BlogsSection::first();

        return view('Client.pages.Blogs.BLOG01.section',[
            'blogs' => $blogs,
            'section' => $section,
        ]);
    }
}
