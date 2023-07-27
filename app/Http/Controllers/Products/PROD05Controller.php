<?php

namespace App\Http\Controllers\Products;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products\PROD05Products;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Products\PROD05ProductsTopic;
use App\Models\Compliances\COMP01Compliances;
use App\Models\Products\PROD05ProductsGallery;
use App\Models\Products\PROD05ProductsSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Products\PROD05ProductsCategory;
use App\Models\Products\PROD05ProductsGalleryType;
use App\Models\Products\PROD05ProductsSubcategory;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Products\PROD05ProductsTopicCategory;
use App\Models\Products\PROD05ProductsGallerySection;

class PROD05Controller extends Controller
{
    protected $path = 'uploads/Products/PROD05/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = PROD05Products::with(['category', 'subcategory'])->sorting()->paginate('32');
        $categories = PROD05ProductsCategory::sorting()->get();
        $subcategories = PROD05ProductsSubcategory::sorting()->get();
        $section = PROD05ProductsSection::first();
        $cropSetting = getCropImage('Products', 'PROD05');

        return view('Admin.cruds.Products.PROD05.index',
            compact('products', 'categories', 'subcategories', 'cropSetting', 'section')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PROD05ProductsCategory::sorting()->pluck('title', 'id');
        $subcategories = PROD05ProductsSubcategory::sorting()->pluck('title', 'id');

        return view('Admin.cruds.Products.PROD05.create',[
            "categories" => $categories,
            "subcategories" => $subcategories,
            'cropSetting' => getCropImage('Products', 'PROD05')
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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_thumbnail = $helper->optimizeImage($request, 'path_image_thumbnail', $this->path, null,100);
        if($path_image_thumbnail) $data['path_image_thumbnail'] = $path_image_thumbnail;

        $data['slug'] = Str::slug($request->title.($request->subtitle?'-'.$request->subtitle:''));

        $data['active'] = $request->active?1:0;
        $data['featured_home'] = $request->featured_home?1:0;

        if ($PROD05Products = PROD05Products::create($data)) {
            Session::flash('success', 'produto cadastrado com sucesso');
            return redirect()->route('admin.prod05.edit', ['PROD05Products' => $PROD05Products->id]);
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_thumbnail);
            Session::flash('error', 'Erro ao cadastradar produto');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products\PROD05Products  $PROD05Products
     * @return \Illuminate\Http\Response
     */
    public function edit(PROD05Products $PROD05Products)
    {
        $categories = PROD05ProductsCategory::sorting()->pluck('title', 'id');
        $subcategories = PROD05ProductsSubcategory::sorting()->pluck('title', 'id');
        $galleryTypes = PROD05ProductsGalleryType::with('galleries')->where('product_id', $PROD05Products->id)->sorting()->get();
        $topicCategories = PROD05ProductsTopicCategory::where('product_id', $PROD05Products->id)->sorting()->get();
        $topicSelectCategories = PROD05ProductsTopicCategory::where('product_id', $PROD05Products->id)->sorting()->pluck('title', 'id');
        $topics = PROD05ProductsTopic::join('prod05_products_topiccategories', 'prod05_products_topics.category_id', 'prod05_products_topiccategories.id')
            ->select('prod05_products_topics.*', 'prod05_products_topiccategories.title as category_title')
            ->where('prod05_products_topiccategories.product_id', $PROD05Products->id)
            ->sorting()
            ->get();
        $galleriesSection = PROD05ProductsGallerySection::where('product_id', $PROD05Products->id)->sorting()->get();

        return view('Admin.cruds.Products.PROD05.edit',[
            "product" => $PROD05Products,
            "categories" => $categories,
            "subcategories" => $subcategories,
            "galleryTypes" => $galleryTypes,
            "galleriesSection" => $galleriesSection,
            "topicSelectCategories" => $topicSelectCategories,
            "topicCategories" => $topicCategories,
            "topics" => $topics,
            'cropSetting' => getCropImage('Products', 'PROD05')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products\PROD05Products  $PROD05Products
     * @return \Illuminate\Http\Response
     */
    public function bannerUpdate(Request $request, PROD05Products $PROD05Products)
    {
        $helper = new HelperArchive();

        $path_image_banner = $helper->optimizeImage($request, 'path_image_banner', $this->path, null,100);
        if($path_image_banner){
            storageDelete($PROD05Products, 'path_image_banner');
            $PROD05Products->path_image_banner = $path_image_banner;
        }
        if($request->delete_path_image_banner && !$path_image_banner){
            storageDelete($PROD05Products, 'path_image_banner');
            $PROD05Products->path_image_banner = null;
        }

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null,100);
        if($path_image_banner_mobile){
            storageDelete($PROD05Products, 'path_image_banner_mobile');
            $PROD05Products->path_image_banner_mobile = $path_image_banner_mobile;
        }
        if($request->delete_path_image_banner_mobile && !$path_image_banner_mobile){
            storageDelete($PROD05Products, 'path_image_banner_mobile');
            $PROD05Products->path_image_banner_mobile = null;
        }

        $PROD05Products->title_banner = $request->title_banner;
        $PROD05Products->subtitle_banner = $request->subtitle_banner;

        if($PROD05Products->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image_banner);
            Storage::delete($path_image_banner_mobile);
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    public function topicUpdate(Request $request, PROD05Products $PROD05Products)
    {
        $PROD05Products->title_section_topic = $request->title_section_topic;
        $PROD05Products->subtitle_section_topic = $request->subtitle_section_topic;

        if($PROD05Products->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products\PROD05Products  $PROD05Products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PROD05Products $PROD05Products)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($PROD05Products, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($PROD05Products, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_thumbnail = $helper->optimizeImage($request, 'path_image_thumbnail', $this->path, null,100);
        if($path_image_thumbnail){
            storageDelete($PROD05Products, 'path_image_thumbnail');
            $data['path_image_thumbnail'] = $path_image_thumbnail;
        }
        if($request->delete_path_image_thumbnail && !$path_image_thumbnail){
            storageDelete($PROD05Products, 'path_image_thumbnail');
            $data['path_image_thumbnail'] = null;
        }

        $data['slug'] = Str::slug($request->title.($request->subtitle?'-'.$request->subtitle:''));

        $data['active'] = $request->active?1:0;
        $data['featured_home'] = $request->featured_home?1:0;

        if ($PROD05Products->fill($data)->save()) {
            Session::flash('success', 'Produto atualizado com sucesso');
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_thumbnail);
            Session::flash('error', 'Erro ao atualizar produto');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products\PROD05Products  $PROD05Products
     * @return \Illuminate\Http\Response
     */
    public function destroy(PROD05Products $PROD05Products)
    {
        storageDelete($PROD05Products, 'path_image');
        storageDelete($PROD05Products, 'path_image_thumbnail');

        if ($PROD05Products->delete()) {
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
        $PROD05Productss = PROD05Products::whereIn('id', $request->deleteAll)->get();
        foreach($PROD05Productss as $PROD05Products){
            storageDelete($PROD05Products, 'path_image');
            storageDelete($PROD05Products, 'path_image_thumbnail');
        }

        if ($deleted = PROD05Products::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' itens deletados com sucessso']);
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
        foreach ($request->arrId as $sorting => $id) {
            PROD05Products::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Products\PROD05Products  $PROD05Products
     * @return \Illuminate\Http\Response
     */
    public function show($PROD05ProductsCategory, $PROD05ProductsSubcategory, PROD05Products $PROD05Products)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Products', 'PROD05', 'show');

        $category = PROD05ProductsCategory::where('slug', $PROD05ProductsCategory)->first();
        $subcategory = PROD05ProductsSubcategory::where('slug', $PROD05ProductsSubcategory)->first();

        $product = PROD05Products::where(['category_id' => $category->id,'subcategory_id' => $subcategory->id, 'id' => $PROD05Products->id])->first();

        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $product->path_image_banner = $product->path_image_banner_mobile;
            break;
        }

        $galleryTypesFirst = PROD05ProductsGalleryType::with('galleries')->where('product_id', $product->id)->active()->first();
        $galleryTypes = PROD05ProductsGalleryType::with('galleries')->where('product_id', $product->id)->active()->get();
        $galleriesSection = PROD05ProductsGallerySection::where('product_id', $product->id)->get();
        $topicCategories = PROD05ProductsTopicCategory::with('topics')->where('product_id', $product->id)->active()->get();
        $compliance = COMP01Compliances::sorting()->first();

        return view('Client.pages.Products.PROD05.show', [
            'sections' => $sections,
            'category' => $category,
            'subcategory' => $subcategory,
            'product' => $product,
            'galleryTypesFirst' => $galleryTypesFirst,
            'galleryTypes' => $galleryTypes,
            'galleriesSection' => $galleriesSection,
            'topicCategories' => $topicCategories,
            'compliance' => $compliance
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, PROD05ProductsCategory $PROD05ProductsCategory, PROD05ProductsSubcategory $PROD05ProductsSubcategory)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Products', 'PROD05', 'page');

        $subcategories = PROD05ProductsSubcategory::query();
        $products = PROD05Products::with(['category', 'subcategory'])->active();

        if($PROD05ProductsCategory->exists){
            $products = $products->where('category_id', $PROD05ProductsCategory->id);
            $subcategories = $subcategories->join('prod05_products', 'prod05_products_subcategories.id', '=', 'prod05_products.subcategory_id')
                ->select('prod05_products_subcategories.*', 'prod05_products.title as product_title')
                ->where('prod05_products.category_id', $PROD05ProductsCategory->id);
                $subcategories = $subcategories->active()->exists()->sorting()->groupBy('prod05_products.subcategory_id')->get();
        } else {
            $subcategories = $subcategories->active()->exists()->sorting()->get();
        }

        if($PROD05ProductsSubcategory->exists){
            $products = $products->where('subcategory_id', $PROD05ProductsSubcategory->id);
        }
        $products = $products->sorting()->paginate(16);

        $section = PROD05ProductsSection::first();

        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $section->path_image_banner = $section->path_image_banner_mobile;
            break;
        }

        $categories = PROD05ProductsCategory::active()->exists()->sorting()->get();

        return view('Client.pages.Products.PROD05.page', [
            'sections' => $sections,
            'section' => $section,
            'products' => $products,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'categoryCurrent' => $PROD05ProductsCategory,
            'subcategoryCurrent' => $PROD05ProductsSubcategory,
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $section = PROD05ProductsSection::first();
        $categories = PROD05ProductsCategory::active()->featuredHome()->exists()->sorting()->get();
        $categoryFirst = PROD05ProductsCategory::active()->exists()->sorting()->first();
        $products = PROD05Products::with(['category', 'subcategory'])->featuredHome()->active()->sorting()->get();

        return view('Client.pages.Products.PROD05.section',[
            'section' => $section,
            'categoryFirst' => $categoryFirst,
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
