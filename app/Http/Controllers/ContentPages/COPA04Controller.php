<?php

namespace App\Http\Controllers\ContentPages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentPages\COPA04ContentPages;
use App\Models\ContentPages\COPA04ContentPagesFaq;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA04ContentPagesTopic;
use App\Models\ContentPages\COPA04ContentPagesGallery;
use App\Models\ContentPages\COPA04ContentPagesTopicItem;
use App\Models\ContentPages\COPA04ContentPagesSectionHero;
use App\Models\ContentPages\COPA04ContentPagesSectionVideo;
use App\Models\ContentPages\COPA04ContentPagesTopiccarousel;
use App\Models\ContentPages\COPA04ContentPagesSectionProducts;
use App\Models\ContentPages\COPA04ContentPagesAdditionalTopics;
use App\Models\ContentPages\COPA04ContentPagesAdditionalContent;
use App\Models\ContentPages\COPA04ContentPagesSectionHighlighted;
use App\Models\ContentPages\COPA04ContentPagesTopiccarousel_cards;
use App\Models\ContentPages\COPA04ContentPagesGallerytopics;
use App\Models\ContentPages\COPA04ContentPagesAdditionalContentImages;
use App\Models\ContentPages\COPA04ContentPagesFaqTopics;
use App\Models\ContentPages\COPA04ContentPagesSectionProducts_Product;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class COPA04Controller extends Controller
{
    protected $path = 'uploads/Module/sectionHeros/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contentPages = COPA04ContentPages::sorting()->get();
        return view('Admin.cruds.ContentPages.COPA04.index', [
            'contentPages' => $contentPages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.create');
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

        $data['slug'] = Str::slug($data['title_page']);

        if($contentPage = COPA04ContentPages::create($data)){
            Session::flash('success', 'Página cadastrada com sucesso');
            return redirect()->route('admin.copa04.edit', ['COPA04ContentPages' => $contentPage->id]);
        }else{
            Session::flash('error', 'Erro ao cadastradar página');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContentPages\COPA04ContentPages  $COPA04ContentPages
     * @return \Illuminate\Http\Response
     */
    public function edit(COPA04ContentPages $COPA04ContentPages)
    {
        $sectionHero = COPA04ContentPagesSectionHero::first();
        $sectionVideo = COPA04ContentPagesSectionVideo::first();
        $sectionHighlighted = COPA04ContentPagesSectionHighlighted::first();
        $sectionTopic = COPA04ContentPagesTopic::first();
        $topicCaroussel = COPA04ContentPagesTopiccarousel::first();
        $gallery = COPA04ContentPagesGallery::first();
        $additionalContent = COPA04ContentPagesAdditionalContent::first();
        $additionalTopics = COPA04ContentPagesAdditionalTopics::sorting()->paginate(30);
        $faq = COPA04ContentPagesFaq::first();
        $sectionProduct = COPA04ContentPagesSectionProducts::first();

        return view('Admin.cruds.ContentPages.COPA04.edit', [
            'contentPage' => $COPA04ContentPages,
            'sectionHero' => $sectionHero,
            'cropSetting' => getCropImage('ContentPages', 'COPA04'),
            'sectionVideo' => $sectionVideo,
            'sectionHighlighted' => $sectionHighlighted,
            'sectionTopic' => $sectionTopic,
            'topicCaroussel' => $topicCaroussel,
            'gallery' => $gallery,
            'additionalContent' => $additionalContent,
            'additionalTopics' => $additionalTopics,
            'faq' => $faq,
            'sectionProduct' => $sectionProduct
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentPages\COPA04ContentPages  $COPA04ContentPages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COPA04ContentPages $COPA04ContentPages)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['title_page']);
        if($COPA04ContentPages->fill($data)->save()){
            Session::flash('success', 'Informações atualizado com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar informações');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentPages\COPA04ContentPages  $COPA04ContentPages
     * @return \Illuminate\Http\Response
     */

    public function destroy(COPA04ContentPages $COPA04ContentPages)
    {
        if($COPA04ContentPages->delete()){
            Session::flash('success', 'Página deletada com sucessso');
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
        if($deleted = COPA04ContentPages::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' páginas deletadas com sucessso']);
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
            COPA04ContentPages::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPages  $COPA04ContentPages
     * @return \Illuminate\Http\Response
     */

    public function show(COPA04ContentPages $COPA04ContentPages)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('ContentPages', 'COPA04', 'show');

        if(!$COPA04ContentPages) $COPA04ContentPages = $COPA04ContentPages->active()->first();

        $sectionHeros = COPA04ContentPagesSectionHero::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $sectionVideo = COPA04ContentPagesSectionVideo::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $sectionHighlighteds = COPA04ContentPagesSectionHighlighted::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $sectionTopic = COPA04ContentPagesTopic::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $TopicItems = COPA04ContentPagesTopicItem::where('contentpage_id', $COPA04ContentPages->id)->active()->sorting()->get();
        $sectiontopicCaroussel = COPA04ContentPagesTopiccarousel::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $CarousselItems = COPA04ContentPagesTopiccarousel_cards::where('contentpage_id', $COPA04ContentPages->id)->active()->sorting()->get();
        $sectionGallery = COPA04ContentPagesGallery::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $galleryItems = COPA04ContentPagesGallerytopics::where('contentpage_id', $COPA04ContentPages->id)->active()->sorting()->get();
        $additionalContent = COPA04ContentPagesAdditionalContent::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $additionalContentImages = COPA04ContentPagesAdditionalContentImages::where('contentpage_id', $COPA04ContentPages->id)->active()->sorting()->get();
        $additionalTopics = COPA04ContentPagesAdditionalTopics::where('contentpage_id', $COPA04ContentPages->id)->active()->get();
        $faq = COPA04ContentPagesFaq::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $faqTopics = COPA04ContentPagesFaqTopics::where('contentpage_id', $COPA04ContentPages->id)->active()->sorting()->get();
        $sectionProduct = COPA04ContentPagesSectionProducts::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $productItem = COPA04ContentPagesSectionProducts_Product::where('contentpage_id', $COPA04ContentPages->id)->active()->sorting()->get();

        return view('Client.pages.ContentPages.COPA04.page',[
            'sections' => $sections,
            'sectionHeros' => $sectionHeros,
            'sectionVideo' => $sectionVideo,
            'sectionHighlighted' => $sectionHighlighteds,
            'sectionTopic' => $sectionTopic,
            'topicItems' => $TopicItems,
            'sectionTopicCarousel' => $sectiontopicCaroussel,
            'carouselItems' => $CarousselItems,
            'sectionGallery' => $sectionGallery,
            'galleryItems' => $galleryItems,
            "sectionAdditionalContent" => $additionalContent,
            "additionalItemImages" => $additionalContentImages,
            "additionalTopics" => $additionalTopics,
            "sectionFaq" => $faq,
            "faqTopics" => $faqTopics,
            'sectionProducts' => $sectionProduct,
            'productItem' => $productItem

        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, COPA04ContentPages $COPA04ContentPages)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('ContentPages', 'COPA04', 'page');

        if(!$COPA04ContentPages) $COPA04ContentPages = $COPA04ContentPages->active()->first();

        $sectionHeros = COPA04ContentPagesSectionHero::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $sectionVideo = COPA04ContentPagesSectionVideo::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $sectionHighlighteds = COPA04ContentPagesSectionHighlighted::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $sectionTopic = COPA04ContentPagesTopic::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $TopicItems = COPA04ContentPagesTopicItem::where('contentpage_id', $COPA04ContentPages->id)->active()->sorting()->get();
        $sectiontopicCaroussel = COPA04ContentPagesTopiccarousel::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $CarousselItems = COPA04ContentPagesTopiccarousel_cards::where('contentpage_id', $COPA04ContentPages->id)->active()->sorting()->get();
        $sectionGallery = COPA04ContentPagesGallery::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $galleryItems = COPA04ContentPagesGallerytopics::where('contentpage_id', $COPA04ContentPages->id)->active()->sorting()->get();
        $additionalContent = COPA04ContentPagesAdditionalContent::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $additionalContentImages = COPA04ContentPagesAdditionalContentImages::where('contentpage_id', $COPA04ContentPages->id)->active()->sorting()->get();
        $additionalTopics = COPA04ContentPagesAdditionalTopics::where('contentpage_id', $COPA04ContentPages->id)->active()->get();
        $faq = COPA04ContentPagesFaq::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $faqTopics = COPA04ContentPagesFaqTopics::where('contentpage_id', $COPA04ContentPages->id)->active()->sorting()->get();
        $sectionProduct = COPA04ContentPagesSectionProducts::where('contentpage_id', $COPA04ContentPages->id)->active()->first();
        $productItem = COPA04ContentPagesSectionProducts_Product::where('contentpage_id', $COPA04ContentPages->id)->active()->sorting()->get();

        return view('Client.pages.ContentPages.COPA04.page',[
            'sections' => $sections,
            'sectionHeros' => $sectionHeros,
            'sectionVideo' => $sectionVideo,
            'sectionHighlighted' => $sectionHighlighteds,
            'sectionTopic' => $sectionTopic,
            'topicItems' => $TopicItems,
            'sectionTopicCarousel' => $sectiontopicCaroussel,
            'carouselItems' => $CarousselItems,
            'sectionGallery' => $sectionGallery,
            'galleryItems' => $galleryItems,
            "sectionAdditionalContent" => $additionalContent,
            "additionalItemImages" => $additionalContentImages,
            "additionalTopics" => $additionalTopics,
            "sectionFaq" => $faq,
            "faqTopics" => $faqTopics,
            'sectionProducts' => $sectionProduct,
            'productItem' => $productItem

        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        return view('');
    }
}
