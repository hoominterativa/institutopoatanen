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

class COPA04Controller extends Controller
{
    protected $path = 'uploads/Module/sectionHeros/images/';

    public function index()
    {   
        $sectionHeros = COPA04ContentPagesSectionHero::paginate(30);
        $sectionVideo = COPA04ContentPagesSectionVideo::first();
        $sectionHighlighteds = COPA04ContentPagesSectionHighlighted::paginate(30);
        $sectionTopic = COPA04ContentPagesTopic::first();
        $topicCaroussel = COPA04ContentPagesTopiccarousel::first();
        $gallery = COPA04ContentPagesGallery::first();
        $additionalContent = COPA04ContentPagesAdditionalContent::first();
        $additionalTopics = COPA04ContentPagesAdditionalTopics::paginate(30);
        $faq = COPA04ContentPagesFaq::first();
        $sectionProduct = COPA04ContentPagesSectionProducts::first();

        return view('Admin.cruds.ContentPages.COPA04.SectionHero.index', [
            'sectionHeros' => $sectionHeros,
            'cropSetting' => getCropImage('ContentPages', 'COPA01'),
            'sectionVideo' => $sectionVideo,
            'sectionHighlighteds' => $sectionHighlighteds,
            'sectionTopic' => $sectionTopic,
            'topicCaroussel' => $topicCaroussel,
            'gallery' => $gallery,
            'additionalContent' => $additionalContent,
            'additionalTopics' => $additionalTopics,
            'faq' => $faq,
            'sectionProduct' => $sectionProduct
        ]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function edit(COPA04ContentPages $COPA04ContentPages)
    {

    }


    public function update(Request $request, COPA04ContentPages $COPA04ContentPages)
    {

    }

    public function destroy(COPA04ContentPages $COPA04ContentPages)
    {

    }

    public function destroySelected(Request $request)
    {

    }

    public function sorting(Request $request)
    {

    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPages  $COPA04ContentPages
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPages $COPA04ContentPages)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Module', 'Model', 'show');

        return view('Client.pages.Module.Model.show',[
            'sections' => $sections
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
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('ContentPages', 'COPA04', 'page');
        $sectionHeros = COPA04ContentPagesSectionHero::active()->first();
        $sectionVideo = COPA04ContentPagesSectionVideo::active()->first();
        $sectionHighlighteds = COPA04ContentPagesSectionHighlighted::active()->first();
        $sectionTopic = COPA04ContentPagesTopic::active()->first();
        $TopicItems = COPA04ContentPagesTopicItem::active()->sorting()->get();
        $sectiontopicCaroussel = COPA04ContentPagesTopiccarousel::active()->first();
        $CarousselItems = COPA04ContentPagesTopiccarousel_cards::active()->sorting()->get();
        $sectionGallery = COPA04ContentPagesGallery::active()->first();
        $galleryItems = COPA04ContentPagesGallerytopics::active()->get();
        $additionalContent = COPA04ContentPagesAdditionalContent::active()->first();
        $additionalContentImages = COPA04ContentPagesAdditionalContentImages::active()->get();
        $additionalTopics = COPA04ContentPagesAdditionalTopics::active()->get();

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
