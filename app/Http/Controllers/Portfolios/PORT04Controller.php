<?php

namespace App\Http\Controllers\Portfolios;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Portfolios\PORT04Portfolios;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Portfolios\PORT04PortfoliosTopic;
use App\Models\Portfolios\PORT04PortfoliosGallery;
use App\Models\Portfolios\PORT04PortfoliosSection;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Portfolios\PORT04PortfoliosCategory;
use App\Models\Portfolios\PORT04PortfoliosAdditionalTopic;

class PORT04Controller extends Controller
{
    protected $path = 'uploads/Portfolios/PORT04/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = PORT04Portfolios::sorting()->get();
        $portfolioCategories = PORT04PortfoliosCategory::sorting()->get();
        $categories = PORT04PortfoliosCategory::exists()->sorting()->pluck('title', 'id');
        $section = PORT04PortfoliosSection::first();
        return view('Admin.cruds.Portfolios.PORT04.index',[
            'portfolios' => $portfolios,
            'portfolioCategories' => $portfolioCategories,
            'categories' => $categories,
            'section' => $section,
            'cropSetting' => getCropImage('Portfolios', 'PORT04')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = PORT04PortfoliosCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Portfolios.PORT04.create', [
            'categories' => $categories,
            'cropSetting' => getCropImage('Portfolios', 'PORT04')
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

        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($data['title']);
        $data['active'] = $request->active?1:0;
        $data['active_banner'] = $request->active_banner?1:0;
        $data['active_content'] = $request->active_content?1:0;
        $data['active_section'] = $request->active_section?1:0;

        //Portfolio
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        //Banner
        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner) $data['path_image_desktop_banner'] = $path_image_desktop_banner;

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner) $data['path_image_mobile_banner'] = $path_image_mobile_banner;

        //Content
        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null,100);
        if($path_image_content) $data['path_image_content'] = $path_image_content;

        if($portfolios = PORT04Portfolios::create($data)){
            Session::flash('success', 'Portfólio cadastrado com sucesso');
            return redirect()->route('admin.port04.edit', ['PORT04Portfolios' => $portfolios->id ]);
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image);
            Storage::delete($path_image_content);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Session::flash('error', 'Erro ao cadastradar o portfólio');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portfolios\PORT04Portfolios  $PORT04Portfolios
     * @return \Illuminate\Http\Response
     */
    public function edit(PORT04Portfolios $PORT04Portfolios)
    {
        $categories = PORT04PortfoliosCategory::sorting()->pluck('title', 'id');
        $galleries = PORT04PortfoliosGallery::where('portfolio_id', $PORT04Portfolios->id)->get();
        $additionalTopics = PORT04PortfoliosAdditionalTopic::where('portfolio_id', $PORT04Portfolios->id)->get();
        $topics = PORT04PortfoliosTopic::where('portfolio_id', $PORT04Portfolios->id)->get();

        return view('Admin.cruds.Portfolios.PORT04.edit', [
            'portfolio' => $PORT04Portfolios,
            'categories' => $categories,
            'galleries' => $galleries,
            'additionalTopics' => $additionalTopics,
            'topics' => $topics,
            'cropSetting' => getCropImage('Portfolios', 'PORT04')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT04Portfolios  $PORT04Portfolios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT04Portfolios $PORT04Portfolios)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($data['title']);
        $data['active'] = $request->active?1:0;
        $data['active_banner'] = $request->active_banner?1:0;
        $data['active_content'] = $request->active_content?1:0;
        $data['active_section'] = $request->active_section?1:0;

        //Portfolio
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($PORT04Portfolios, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($PORT04Portfolios, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($PORT04Portfolios, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($PORT04Portfolios, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        //Banner
        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner){
            storageDelete($PORT04Portfolios, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if($request->delete_path_image_desktop_banner && !$path_image_desktop_banner){
            storageDelete($PORT04Portfolios, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner){
            storageDelete($PORT04Portfolios, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if($request->delete_path_image_mobile_banner && !$path_image_mobile_banner){
            storageDelete($PORT04Portfolios, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }

        //Content
        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null,100);
        if($path_image_content){
            storageDelete($PORT04Portfolios, 'path_image_content');
            $data['path_image_content'] = $path_image_content;
        }
        if($request->delete_path_image_content && !$path_image_content){
            storageDelete($PORT04Portfolios, 'path_image_content');
            $data['path_image_content'] = null;
        }

        if($PORT04Portfolios->fill($data)->save()){
            Session::flash('success', 'Portfólio atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
            Storage::delete($path_image_content);
            Session::flash('error', 'Erro ao atualizar o portfólio');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT04Portfolios  $PORT04Portfolios
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT04Portfolios $PORT04Portfolios)
    {
        $galleries = PORT04PortfoliosGallery::where('portfolio_id', $PORT04Portfolios->id)->get();
        if($galleries->count()) {
            foreach ($galleries as $gallery) {
                storageDelete($gallery, 'path_image');
                $gallery->delete();
            }
        }

        $additionalTopics = PORT04PortfoliosAdditionalTopic::where('portfolio_id', $PORT04Portfolios->id)->get();
        if($additionalTopics->count()) {
            foreach ($additionalTopics as $additionalTopic) {
                storageDelete($additionalTopic, 'path_image_icon');
                $additionalTopic->delete();
            }
        }

        $topics = PORT04PortfoliosTopic::where('portfolio_id', $PORT04Portfolios->id)->get();
        if($topics->count()) {
            foreach ($topics as $topic) {
                storageDelete($topic, 'path_image_icon');
                $topic->delete();
            }
        }

        storageDelete($PORT04Portfolios, 'path_image');
        storageDelete($PORT04Portfolios, 'path_image_icon');
        storageDelete($PORT04Portfolios, 'path_image_content');
        storageDelete($PORT04Portfolios, 'path_image_desktop_banner');
        storageDelete($PORT04Portfolios, 'path_image_mobile_banner');

        if($PORT04Portfolios->delete()){
            Session::flash('success', 'Portfólio deletado com sucessso');
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

        $PORT04Portfolioss = PORT04Portfolios::whereIn('id', $request->deleteAll)->get();
        foreach($PORT04Portfolioss as $PORT04Portfolios){

            $galleries = PORT04PortfoliosGallery::where('portfolio_id', $PORT04Portfolios->id)->get();
            if($galleries->count()) {
                foreach ($galleries as $gallery) {
                    storageDelete($gallery, 'path_image');
                    $gallery->delete();
                }
            }

            $additionalTopics = PORT04PortfoliosAdditionalTopic::where('portfolio_id', $PORT04Portfolios->id)->get();
            if($additionalTopics->count()) {
                foreach ($additionalTopics as $additionalTopic) {
                    storageDelete($additionalTopic, 'path_image_icon');
                    $additionalTopic->delete();
                }
            }

            $topics = PORT04PortfoliosTopic::where('portfolio_id', $PORT04Portfolios->id)->get();
            if($topics->count()) {
                foreach ($topics as $topic) {
                    storageDelete($topic, 'path_image_icon');
                    $topic->delete();
                }
            }

            storageDelete($PORT04Portfolios, 'path_image');
            storageDelete($PORT04Portfolios, 'path_image_icon');
            storageDelete($PORT04Portfolios, 'path_image_content');
            storageDelete($PORT04Portfolios, 'path_image_desktop_banner');
            storageDelete($PORT04Portfolios, 'path_image_mobile_banner');
        }

        if($deleted = PORT04Portfolios::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Portfólios deletados com sucessso']);
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
            PORT04Portfolios::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Portfolios\PORT04Portfolios  $PORT04Portfolios
     * @return \Illuminate\Http\Response
     */
    //public function show(PORT04Portfolios $PORT04Portfolios)
    public function show( $PORT04PortfoliosCategory, PORT04Portfolios $PORT04Portfolios )
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Portfolios', 'PORT04', 'show');

        $category = PORT04PortfoliosCategory::where('slug', $PORT04PortfoliosCategory)->first();
        $portfolio = PORT04Portfolios::where(['category_id' => $category->id, 'id' => $PORT04Portfolios->id])->first();
        $additionalTopics = PORT04PortfoliosAdditionalTopic::where('portfolio_id', $portfolio->id)->get();
        $topics = PORT04PortfoliosTopic::where('portfolio_id', $portfolio->id)->get();
        $galleries = PORT04PortfoliosGallery::where('portfolio_id', $portfolio->id)->get();

        $relationships = PORT04Portfolios::where('category_id', $PORT04Portfolios->category_id)->whereNotIn('id', [$PORT04Portfolios->id])->active()->sorting()->get();

        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($portfolio) $portfolio->path_image_desktop_banner = $portfolio->path_image_mobile_banner;
            break;
        }

        return view('Client.pages.Portfolios.PORT04.show',[
            'sections' => $sections,
            'portfolio' => $portfolio,
            'additionalTopics' => $additionalTopics,
            'topics' => $topics,
            'galleries' => $galleries,
            'relationships' => $relationships
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, PORT04PortfoliosCategory $PORT04PortfoliosCategory)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Portfolios', 'PORT04', 'page');

        $categories = PORT04PortfoliosCategory::active()->exists()->sorting()->get();
        $portfolios = PORT04Portfolios::active();
        if($PORT04PortfoliosCategory->exists){
            $portfolios = $portfolios->where('category_id', $PORT04PortfoliosCategory->id);

            foreach ($categories as $category) {
                if($PORT04PortfoliosCategory->id==$category->id){
                    $category->selected = true;
                }
            }
        }

        $portfolios = $portfolios->active()->sorting()->get();
        $section = PORT04PortfoliosSection::first();

        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($section) $section->path_image_desktop_banner = $section->path_image_mobile_banner;
            break;
        }


        return view('Client.pages.Portfolios.PORT04.page',[
            'sections' => $sections,
            'categories' => $categories,
            'portfolios' => $portfolios,
            'section' => $section
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $section = PORT04PortfoliosSection::activeSection()->first();
        $portfolios = PORT04Portfolios::with('category')->active()->featured()->sorting()->get();
        return view('Client.pages.Portfolios.PORT04.section', [
            'section' => $section,
            'portfolios' => $portfolios
        ]);
    }
}
