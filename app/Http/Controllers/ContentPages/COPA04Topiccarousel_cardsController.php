<?php

namespace App\Http\Controllers\ContentPages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA04ContentPagesTopiccarousel;
use App\Models\ContentPages\COPA04ContentPagesTopiccarousel_cards;

class COPA04Topiccarousel_cardsController extends Controller
{
    protected $path = 'uploads/ContentPages/COPA04/images/topiccarousel/';

    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.TopicCarouselCards.create', [
            'cropSetting' => getCropImage('ContentPages', 'COPA01')
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        $helper = new HelperArchive();
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if(COPA04ContentPagesTopiccarousel_cards::create($data)){
            $sectionTopicCarousel = COPA04ContentPagesTopiccarousel::active()->first();
            Session::flash('success', 'Item cadastrado com sucesso!');
            return redirect()->route('admin.copa04.topicCaroussel.edit', [$sectionTopicCarousel->id]);
        }else{
            Session::flash('error', 'Erro ao cadastradar o item!');
            return redirect()->back();
        }

    
    }


    public function edit(COPA04ContentPagesTopiccarousel_cards $TopiccarouselCards)
    {
       return view('Admin.cruds.ContentPages.COPA04.TopicCarouselCards.edit', [
        'TopiccarouselCards' => $TopiccarouselCards,
        'cropSetting' => getCropImage('ContentPages', 'COPA01')
       ]);
    }


    public function update(Request $request, COPA04ContentPagesTopiccarousel_cards $TopiccarouselCards)
    {

        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;
        
        $helper = new HelperArchive();
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($TopiccarouselCards, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($TopiccarouselCards, 'path_image');
            $data['path_image'] = null;
        }

        if($TopiccarouselCards->fill($data)->save()){
            $sectionTopicCarousel = COPA04ContentPagesTopiccarousel::active()->first();
            Session::flash('success', 'Item atualizado com sucesso!');
            return redirect()->route('admin.copa04.topicCaroussel.edit', [$sectionTopicCarousel->id]);
        }else{
            Session::flash('error', 'Erro ao atualizar item!');
            return redirect()->back();
        }
    }

    public function destroy(COPA04ContentPagesTopiccarousel_cards $TopiccarouselCards)
    {
        storageDelete($TopiccarouselCards, 'path_image');

        if($TopiccarouselCards->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }

    public function destroySelected(Request $request)
    {

        $TopiccarouselCards = COPA04ContentPagesTopiccarousel_cards::whereIn('id', $request->deleteAll)->get();
        foreach($TopiccarouselCards as $TopiccarouselCard){
            storageDelete($TopiccarouselCard, 'path_image');
        }


        if($deleted = COPA04ContentPagesTopiccarousel_cards::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
        }
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id){
            COPA04ContentPagesTopiccarousel_cards::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPagesTopiccarousel_cards  $COPA04ContentPagesTopiccarousel_cards
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPagesTopiccarousel_cards $COPA04ContentPagesTopiccarousel_cards)
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Module', 'Model', 'page');

        return view('Client.pages.Module.Model.page',[
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
        return view('');
    }
}
