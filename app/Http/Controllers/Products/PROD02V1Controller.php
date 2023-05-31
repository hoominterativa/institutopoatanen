<?php

namespace App\Http\Controllers\Products;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products\PROD02V1Products;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Products\PROD02V1ProductsBanner;
use App\Models\Products\PROD02V1ProductsGallery;
use App\Models\Products\PROD02V1ProductsSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Products\PROD02V1ProductsCategory;
use App\Http\Controllers\IncludeSectionsController;

class PROD02V1Controller extends Controller
{
    protected $path = 'uploads/Products/PROD02V1/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = PROD02V1Products::sorting()->paginate(20);
        $productCategories = PROD02V1ProductsCategory::sorting()->paginate(20);
        $categories = PROD02V1ProductsCategory::exists()->sorting()->pluck('title', 'id');
        $banner = PROD02V1ProductsBanner::first();
        $section = PROD02V1ProductsSection::first();
        return view('Admin.cruds.Products.PROD02V1.index', [
            'products' => $products,
            'categories' => $categories,
            'productCategories' => $productCategories,
            'banner' => $banner,
            'section' => $section,
            'cropSetting' => getCropImage('Products', 'PROD02V1')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PROD02V1ProductsCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Products.PROD02V1.create', [
            'categories' => $categories,
            'cropSetting' => getCropImage('Products', 'PROD02V1')
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

        if($product = PROD02V1Products::create($data)){
            Session::flash('success', 'Produto cadastrado com sucesso');
            return redirect()->route('admin.prod02v1.edit', ['PROD02V1Product' => $product->id]);
        }else{
            Storage::delete($path_image_box);
            Session::flash('success', 'Erro ao cadastradar o produto');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products\PROD02V1Products  $PROD02V1Products
     * @return \Illuminate\Http\Response
     */
    public function edit(PROD02V1Products $PROD02V1Products)
    {
        $galleries = PROD02V1ProductsGallery::where('product_id', $PROD02V1Products->id)->sorting()->get();
        $categories = PROD02V1ProductsCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Products.PROD02V1.edit', [
            'product' => $PROD02V1Products,
            'categories' => $categories,
            'galleries' => $galleries,
            'cropSetting' => getCropImage('Products', 'PROD02V1')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products\PROD02V1Products  $PROD02V1Products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PROD02V1Products $PROD02V1Products)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($data['title']);

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null, 100);
        if($path_image_box){
            storageDelete($PROD02V1Products, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($PROD02V1Products, 'path_image_box');
            $data['path_image_box'] = null;
        }

        if($PROD02V1Products->fill($data)->save()){
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
     * @param  \App\Models\Products\PROD02V1Products  $PROD02V1Products
     * @return \Illuminate\Http\Response
     */
    public function destroy(PROD02V1Products $PROD02V1Products)
    {
        $galleries = PROD02V1ProductsGallery::where('product_id', $PROD02V1Products->id)->get();
        foreach ($galleries as $gallery) {
            storageDelete($gallery, 'path_image');
            $gallery->delete();
        }

        storageDelete($PROD02V1Products, 'path_image_box');

        if($PROD02V1Products->delete()){
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

        $PROD02V1Productss = PROD02V1Products::whereIn('id', $request->deleteAll)->get();
        foreach($PROD02V1Productss as $PROD02V1Products){
            $galleries = PROD02V1ProductsGallery::where('product_id', $PROD02V1Products->id)->get();
            foreach ($galleries as $gallery) {
                storageDelete($gallery, 'path_image');
                $gallery->delete();
        }
            storageDelete($PROD02V1Products, 'path_image_box');
        }


        if($deleted = PROD02V1Products::whereIn('id', $request->deleteAll)->delete()){
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
            PROD02V1Products::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Products\PROD02V1Products  $PROD02V1Products
     * @return \Illuminate\Http\Response
     */
    //public function show(PROD02V1Products $PROD02V1Products)
    public function show()
    {
        return view('Client.pages.Products.PROD02V1.show');
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, PROD02V1ProductsCategory $PROD02V1ProductsCategory)
    {

        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $banner = PROD02V1ProductsBanner::active()->first();
                if($banner) $banner->path_image_desktop = $banner->path_image_mobile;
                break;
            default:
                $banner = PROD02V1ProductsBanner::active()->first();
                break;
        }

        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Products', 'PROD02V1');

        $categories = PROD02V1ProductsCategory::active()->exists()->sorting()->get();
        $products = PROD02V1Products::with('galleries')->active();

        if($PROD02V1ProductsCategory->exists){
            $products = $products->where('category_id', $PROD02V1ProductsCategory->id);

            foreach ($categories as $category) {
                if($PROD02V1ProductsCategory->id==$category->id){
                    $category->selected = true;
                }
            }
        }

        $products = $products->sorting()->get();


        return view('Client.pages.Products.PROD02V1.page',[
            'sections' => $sections,
            'banner' => $banner,
            'categories' => $categories,
            'products' => $products
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $categories = PROD02V1ProductsCategory::active()->featured()->exists()->sorting()->get();
        $products = PROD02V1Products::with('galleries')->active()->featured()->sorting()->get();
        $section = PROD02V1ProductsSection::active()->first();

        return view('Client.pages.Products.PROD02V1.section', [
            'products' => $products,
            'categories' => $categories,
            'section' => $section
        ]);
    }
}
