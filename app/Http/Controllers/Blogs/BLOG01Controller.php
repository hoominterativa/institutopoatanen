<?php

namespace App\Http\Controllers\Blogs;

use App\Models\Blogs\BLOG01Blogs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Blogs\BLOG01BlogsCategory;
use Carbon\Carbon;

class BLOG01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blogs = BLOG01Blogs::with('category');

        if($request->category_id){
            $blogs = $blogs->where('category_id', $request->category_id);
        }
        if($request->title){
            $blogs = $blogs->where('title','LIKE', '%'.$request->title.'%');
        }
        if($request->date_start && $request->date_end){
            $request->date_start = Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d');
            $request->date_end = Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d');
            $blogs = $blogs->whereBetween('publishing', [$request->date_start, $request->date_end]);
        }
        if($request->date_start && !$request->date_end){
            $request->date_start = Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d');
            $blogs = $blogs->where('publishing','>=', $request->date_start);
        }
        if(!$request->date_start && $request->date_end){
            $request->date_end = Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d');
            $blogs = $blogs->where('publishing','<=', $request->date_end);
        }

        $blogs = $blogs->paginate('32');

        $categories = BLOG01BlogsCategory::exists()->pluck('title', 'id');
        return view('Admin.cruds.Blogs.BLOG01.index',[
            'blogs' => $blogs,
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = BLOG01BlogsCategory::pluck('title', 'id');
        return view('Admin.cruds.Blogs.BLOG01.create',[
            'categories' => $categories
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

        /*
        Use the code below to upload image, if not, delete code

        $path = 'uploads/Module/Code/images/';
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $path, 200, 80);

        if($path_image) $data['path_image'] = $path_image;

        Use the code below to upload archive, if not, delete code

        $path = 'uploads/Module/Code/archives/';
        $helper = new HelperArchive();

        $path_archive = $helper->uploadArchive($request, 'path_archive', $path);

        if($path_archive) $data['path_archive'] = $path_archive;

        */

        if(BLOG01Blogs::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.code.index');
        }else{
            //Storage::delete($path_image);
            //Storage::delete($path_archive);
            Session::flash('success', 'Erro ao cadastradar o item');
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
        //
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

        /*
        Use the code below to upload image, if not, delete code

        $path = 'uploads/Module/Code/images/';
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $path, 200, 80);
        if($path_image){
            storageDelete($BLOG01Blogs, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($BLOG01Blogs, 'path_image');
            $data['path_image'] = null;
        }
        */

        /*
        Use the code below to upload archive, if not, delete code

        $path = 'uploads/Module/Code/archives/';
        $helper = new HelperArchive();

        $path_archive = $helper->uploadArchive($request, 'path_archive', $path);

        if($path_archive){
            storageDelete($BLOG01Blogs, 'path_archive');
            $data['path_archive'] = $path_archive;
        }

        if($request->delete_path_archive && !$path_archive){
            storageDelete($BLOG01Blogs, 'path_archive');
            $data['path_archive'] = null;
        }

        */

        if($BLOG01Blogs->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->route('admin.code.index');
        }else{
            //Storage::delete($path_image);
            //Storage::delete($path_archive);
            Session::flash('success', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blogs\BLOG01Blogs  $BLOG01Blogs
     * @return \Illuminate\Http\Response
     */
    public function destroy(BLOG01Blogs $BLOG01Blogs)
    {
        //storageDelete($BLOG01Blogs, 'path_image');
        //storageDelete($BLOG01Blogs, 'path_archive');

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
        /* Use the code below to upload image or archive, if not, delete code

        $BLOG01Blogss = BLOG01Blogs::whereIn('id', $request->deleteAll)->get();
        foreach($BLOG01Blogss as $BLOG01Blogs){
            storageDelete($BLOG01Blogs, 'path_image');
            storageDelete($BLOG01Blogs, 'path_archive');
        }
        */

        if($deleted = BLOG01Blogs::whereIn('id', $request->deleteAll)->delete()){
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
     * @param  \App\Models\Blogs\BLOG01Blogs  $BLOG01Blogs
     * @return \Illuminate\Http\Response
     */
    //public function show(BLOG01Blogs $BLOG01Blogs)
    public function show()
    {
        return view('Client.pages.Blogs.BLOG01.show');
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Blogs', 'BLOG01');

        return view('Client.pages.Blogs.BLOG01.page',[
            'sections' => $sections
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        return view('Client.pages.Blogs.BLOG01.section');
    }
}
