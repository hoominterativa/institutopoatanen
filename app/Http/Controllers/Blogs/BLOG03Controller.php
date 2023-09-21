<?php

namespace App\Http\Controllers\Blogs;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Blogs\BLOG03Blogs;
use App\Http\Controllers\Controller;
use App\Models\Blogs\BLOG03BlogsBanner;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Blogs\BLOG03BlogsSection;
use Illuminate\Support\Facades\Response;
use App\Models\Blogs\BLOG03BlogsCategory;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class BLOG03Controller extends Controller
{
    protected $path = 'uploads/Blogs/BLOG03/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = BLOG03Blogs::with('category')->sorting()->paginate('32');
        $categories = BLOG03BlogsCategory::exists()->sorting()->pluck('title', 'id');
        $blogCategories = BLOG03BlogsCategory::sorting()->get();
        $section = BLOG03BlogsSection::first();
        $banner = BLOG03BlogsBanner::first();

        return view('Admin.cruds.Blogs.BLOG03.index',[
            'blogs' => $blogs,
            'categories' => $categories,
            'blogCategories' => $blogCategories,
            'section' => $section,
            'banner' => $banner,
            'cropSetting' => getCropImage('Blogs', 'BLOG03')
        ]);
    }

    public function filter(Request $request)
    {
        Session::put('filter.category_id', $request->category_id);
        Session::put('filter.title', $request->title);
        Session::put('filter.date_start', $request->date_start);
        Session::put('filter.date_end', $request->date_end);
        Session::put('filter.active', $request->active);
        Session::put('filter.featured', $request->featured);
        Session::save();

        $blogs = BLOG03Blogs::with('category');

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
        if(Session::get('filter.featured')){
            $blogs = $blogs->where('featured', 1);
        }

        $blogs = $blogs->with('category')->sorting()->paginate('32');
        $categories = BLOG03BlogsCategory::exists()->sorting()->pluck('title', 'id');
        $blogCategories = BLOG03BlogsCategory::sorting()->get();
        $section = BLOG03BlogsSection::first();
        $banner = BLOG03BlogsBanner::first();

        return view('Admin.cruds.Blogs.BLOG01.index',[
            'blogs' => $blogs,
            'categories' => $categories,
            'blogCategories' => $blogCategories,
            'section' => $section,
            'banner' => $banner
        ]);
    }

    public function clearFilter()
    {
        Session::forget('filter');
        return redirect()->route('admin.blog03.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = BLOG03BlogsCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Blogs.BLOG03.create',[
            'categories' => $categories,
            'cropSetting' => getCropImage('Blogs', 'BLOG03')
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

        $data['slug'] = Str::slug($request->title);
        $data['featured'] = $request->featured?1:0;
        $data['active'] = $request->active?1:0;
        $data['publishing'] = Carbon::createFromFormat('d/m/Y', $request->publishing)->format('Y-m-d');

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(BLOG03Blogs::create($data)){
            Session::flash('success', 'Blog cadastrado com sucesso');
            return redirect()->route('admin.blog03.index');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o blog');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blogs\BLOG03Blogs  $BLOG03Blogs
     * @return \Illuminate\Http\Response
     */
    public function edit(BLOG03Blogs $BLOG03Blogs)
    {
        $categories = BLOG03BlogsCategory::pluck('title', 'id');
        $BLOG03Blogs->publishing = Carbon::parse($BLOG03Blogs->publishing)->format('d/m/Y');
        return view('Admin.cruds.Blogs.BLOG03.edit',[
            'blog' => $BLOG03Blogs,
            'categories' => $categories,
            'cropSetting' => getCropImage('Blogs', 'BLOG03')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blogs\BLOG03Blogs  $BLOG03Blogs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BLOG03Blogs $BLOG03Blogs)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['slug'] = Str::slug($request->title);
        $data['featured'] = $request->featured?1:0;
        $data['active'] = $request->active?1:0;
        $data['publishing'] = Carbon::createFromFormat('d/m/Y', $request->publishing)->format('Y-m-d');

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($BLOG03Blogs, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($BLOG03Blogs, 'path_image');
            $data['path_image'] = null;
        }

        if($BLOG03Blogs->fill($data)->save()){
            Session::flash('success', 'Blog atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar o blog');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blogs\BLOG03Blogs  $BLOG03Blogs
     * @return \Illuminate\Http\Response
     */
    public function destroy(BLOG03Blogs $BLOG03Blogs)
    {
        storageDelete($BLOG03Blogs, 'path_image');

        if($BLOG03Blogs->delete()){
            Session::flash('success', 'Blog deletado com sucessso');
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
        $BLOG03Blogss = BLOG03Blogs::whereIn('id', $request->deleteAll)->get();
        foreach($BLOG03Blogss as $BLOG03Blogs){
            storageDelete($BLOG03Blogs, 'path_image');
        }

        if($deleted = BLOG03Blogs::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Blogs deletados com sucessso']);
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
            BLOG03Blogs::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Blogs\BLOG03Blogs  $BLOG03Blogs
     * @return \Illuminate\Http\Response
     */
    //public function show(BLOG03Blogs $BLOG03Blogs)
    public function show($BLOG03BlogsCategory, BLOG03Blogs $BLOG03Blogs)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Blogs', 'BLOG03', 'show');

        $blogsRelated = BLOG03Blogs::with('category')
            ->where('category_id', $BLOG03Blogs->category_id)
            ->whereNotIn('id', [$BLOG03Blogs->id])
            ->sorting()
            ->orderBy('featured', 'DESC')
            ->limit('5')
            ->get();

        $BLOG03Blogs->text = conveterOembedCKeditor($BLOG03Blogs->text);

        return view('Client.pages.Blogs.BLOG03.show',[
            'blog' => $BLOG03Blogs,
            'blogsRelated' => $blogsRelated,
            'sections' => $sections
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, BLOG03BlogsCategory $BLOG03BlogsCategory)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Blogs', 'BLOG03');

        $categories = BLOG03BlogsCategory::exists()->active()->sorting()->get();
        $blogs = BLOG03Blogs::with('category')->active();

        if($BLOG03BlogsCategory->exists){
            $blogs = $blogs->where('category_id', $BLOG03BlogsCategory->id);

            foreach ($categories as $category) {
                if($BLOG03BlogsCategory->id==$category->id){
                    $category->selected = true;
                }
            }
        }

        $search = $request->buscar;

        if($search) {
            $blogs = $blogs->where('title', 'like', "%$search%");
        }

        $blogs = $blogs->sorting()->paginate(9);

        $banner = BLOG03BlogsBanner::active()->first();

        return view('Client.pages.Blogs.BLOG03.page',[
            'sections' => $sections,
            'categories' => $categories,
            'blogs' => $blogs,
            'banner' => $banner,
            'buscar' => $search
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $blogs = BLOG03Blogs::with('category')->active()->featured()->sorting()->get();
        $section = BLOG03BlogsSection::first();

        $category = BLOG03BlogsCategory::first();

        return view('Client.pages.Blogs.BLOG03.section',[
            'blogs' => $blogs,
            'section' => $section,
            'category' => $category
        ]);
    }
}
