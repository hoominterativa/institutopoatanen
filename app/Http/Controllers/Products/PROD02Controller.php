<?php

namespace App\Http\Controllers\Products;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products\PROD02Products;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Products\PROD02ProductsCategory;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Products\PROD02ProductsGallery;

class PROD02Controller extends Controller
{
    protected $path = 'uploads/Products/PROD02/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = PROD02Products::sorting()->paginate(20);
        $productCategories = PROD02ProductsCategory::sorting()->paginate(20);
        $categories = PROD02ProductsCategory::exists()->sorting()->pluck('title', 'id');
        return view('Admin.cruds.Products.PROD02.index', [
            'products' => $products,
            'categories' => $categories,
            'productCategories' => $productCategories,
            'cropSetting' => getCropImage('Products', 'PROD02')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PROD02ProductsCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Products.PROD02.create', [
            'categories' => $categories,
            'cropSetting' => getCropImage('Products', 'PROD02')
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
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($data['title']);

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null, 100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;

        if(PROD02Products::create($data)){
            Session::flash('success', 'Produto cadastrado com sucesso');
            return redirect()->route('admin.prod02.index');
        }else{
            Storage::delete($path_image_box);
            Session::flash('success', 'Erro ao cadastradar o produto');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products\PROD02Products  $PROD02Products
     * @return \Illuminate\Http\Response
     */
    public function edit(PROD02Products $PROD02Products)
    {
        $galleries = PROD02ProductsGallery::where('product_id', $PROD02Products->id)->sorting()->get();
        $categories = PROD02ProductsCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Products.PROD02.edit', [
            'product' => $PROD02Products,
            'categories' => $categories,
            'galleries' => $galleries,
            'cropSetting' => getCropImage('Products', 'PROD02')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products\PROD02Products  $PROD02Products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PROD02Products $PROD02Products)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($data['title']);

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null, 100);
        if($path_image_box){
            storageDelete($PROD02Products, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($PROD02Products, 'path_image_box');
            $data['path_image_box'] = null;
        }

        if($PROD02Products->fill($data)->save()){
            Session::flash('success', 'Produto atualizado com sucesso');
        }else{
            Storage::delete($path_image_box);
            Session::flash('success', 'Erro ao atualizar o produto');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products\PROD02Products  $PROD02Products
     * @return \Illuminate\Http\Response
     */
    public function destroy(PROD02Products $PROD02Products)
    {
        $galleries = PROD02ProductsGallery::where('product_id', $PROD02Products->id)->get();
        foreach ($galleries as $gallery) {
            storageDelete($gallery, 'path_image');
            $gallery->delete();
        }

        storageDelete($PROD02Products, 'path_image_box');

        if($PROD02Products->delete()){
            Session::flash('success', 'Produto deletado com sucessso');
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

        $PROD02Productss = PROD02Products::whereIn('id', $request->deleteAll)->get();
        foreach($PROD02Productss as $PROD02Products){
            $galleries = PROD02ProductsGallery::where('product_id', $PROD02Products->id)->get();
            foreach ($galleries as $gallery) {
                storageDelete($gallery, 'path_image');
                $gallery->delete();
        }
            storageDelete($PROD02Products, 'path_image_box');
        }


        if($deleted = PROD02Products::whereIn('id', $request->deleteAll)->delete()){
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
            PROD02Products::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Products\PROD02Products  $PROD02Products
     * @return \Illuminate\Http\Response
     */
    //public function show(PROD02Products $PROD02Products)
    public function show()
    {
        return view('Client.pages.Products.PROD02.show');
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Products', 'PROD02');

        return view('Client.pages.Products.PROD02.page',[
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
        return view('Client.pages.Products.PROD02.section');
    }
}
