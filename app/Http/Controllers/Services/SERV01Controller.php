<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV01Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV01ServicesCategories;
use App\Models\Services\SERV01ServicesSubcategories;

class SERV01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = SERV01Services::with(['getCategory', 'getSubcategory'])->sorting()->paginate('32');
        return view('Admin.cruds.Services.SERV01.index',[
            'services' => $services
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = SERV01ServicesCategories::sorting()->pluck('name', 'id');
        $subcategories = SERV01ServicesSubcategories::sorting()->pluck('name', 'id');
        return view('Admin.cruds.Services.SERV01.create',[
            'categories' => $categories,
            'subcategories' => $subcategories
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
        $path = 'uploads/images/Services/SERV01/';
        $helperArchive = new HelperArchive();
        $path_image_box = $helperArchive->renameArchiveUpload($request, 'path_image_box');
        $path_image_inner = $helperArchive->renameArchiveUpload($request, 'path_image_inner');

        $SERV01Services = new SERV01Services();

        if($path_image_inner){
            $SERV01Services->path_image_inner = $path.$path_image_inner;
            $request->path_image_inner->storeAs($path, $path_image_inner);
        }

        if(is_array($path_image_box)){
            $SERV01Services->path_image_box = $path.$path_image_box[1];
            Storage::put($path.$path_image_box[1], base64_decode($path_image_box[0]));
        }

        $SERV01Services->category_id = $request->category_id?:null;
        $SERV01Services->subcategory_id = $request->subcategory_id?:null;
        $SERV01Services->title = $request->title;
        $SERV01Services->description = $request->description;
        $SERV01Services->text = $request->text;
        $SERV01Services->slug = Str::slug($request->title);
        $SERV01Services->active = $request->active;

        if($SERV01Services->save()){
            Session::flash('success', 'Serviço cadastrado com sucessso');
            return redirect()->route('admin.serv01.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV01Services  $SERV01Services
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV01Services $SERV01Services)
    {
        $categories = SERV01ServicesCategories::sorting()->pluck('name', 'id');
        $subcategories = SERV01ServicesSubcategories::sorting()->pluck('name', 'id');
        return view('Admin.cruds.Services.SERV01.edit',[
            'categories' => $categories,
            'subcategories' => $subcategories,
            'service' => $SERV01Services
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV01Services  $SERV01Services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV01Services $SERV01Services)
    {
        $path = 'uploads/images/Services/SERV01/';
        $helperArchive = new HelperArchive();

        $path_image_inner = $helperArchive->renameArchiveUpload($request, 'path_image_inner');
        $path_image_box = $helperArchive->renameArchiveUpload($request, 'path_image_box');

        if(isset($request->delete_path_image_inner) && !$path_image_inner){
            $inputFile = $request->delete_path_image_inner;
            Storage::delete($SERV01Services->$inputFile);
            $SERV01Services->path_image_inner = null;
        }
        if(isset($request->delete_path_image_box) && !$path_image_box){
            $inputFile = $request->delete_path_image_box;
            Storage::delete($SERV01Services->$inputFile);
            $SERV01Services->path_image_box = null;
        }

        if($path_image_inner){
            Storage::delete($SERV01Services->path_image_inner);
            $SERV01Services->path_image_inner = $path.$path_image_inner;
            $request->path_image_inner->storeAs($path, $path_image_inner);
        }

        if(is_array($path_image_box)){
            Storage::delete($SERV01Services->path_image_box);
            $SERV01Services->path_image_box = $path.$path_image_box[1];
            Storage::put($path.$path_image_box[1], base64_decode($path_image_box[0]));
        }

        $SERV01Services->category_id = $request->category_id?:null;
        $SERV01Services->subcategory_id = $request->subcategory_id?:null;
        $SERV01Services->title = $request->title;
        $SERV01Services->description = $request->description;
        $SERV01Services->text = $request->text;
        $SERV01Services->slug = Str::slug($request->title);
        $SERV01Services->active = $request->active;

        if($SERV01Services->save()){
            Session::flash('success', 'Serviço atualizado com sucessso');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV01Services  $SERV01Services
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV01Services $SERV01Services)
    {
        if($SERV01Services->delete()){
            Session::flash('success', 'Serviço deletado com sucessso');
            return redirect()->back();
        }
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request)
    {
        if($deleted = SERV01Services::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' serviços deletados com sucessso']);
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
            SERV01Services::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Services\SERV01Services  $SERV01Services
     * @return \Illuminate\Http\Response
     */
    public function show(SERV01Services $SERV01Services)
    {
        return view('Client.pages.Services.SERV01.show',[
            'service' => $SERV01Services
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
        $services = SERV01Services::sorting()->paginate(16);
        $categories = SERV01ServicesCategories::sorting()->get();
        $subcategories = SERV01ServicesSubcategories::sorting()->get();
        return view('Client.pages.Services.SERV01.page',[
            'services' => $services,
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $services = SERV01Services::sorting()->paginate(16);
        $categories = SERV01ServicesCategories::sorting()->get();
        $subcategories = SERV01ServicesSubcategories::sorting()->get();

        return view('Client.pages.Services.SERV01.section',[
            'services' => $services,
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }
}
