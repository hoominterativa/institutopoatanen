<?php

namespace App\Http\Controllers\ContentPages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\ContentPages\COPA04ContentPages;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\ContentPages\COPA04ContentPagesTopic;
use App\Models\ContentPages\COPA04ContentPagesTopicItem;

class COPA04TopicItemController extends Controller
{
    protected $path = 'uploads/Module/Topics/images/';

    public function create()
    {
        return view('Admin.cruds.ContentPages.COPA04.Topics.create', [
            'cropSetting' => getCropImage('ContentPages', 'COPA04')
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;
        $helper = new HelperArchive();
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;        

        if(COPA04ContentPagesTopicItem::create($data)){
            $COPA04ContentPages = COPA04ContentPages::first();
            Session::flash('success', 'Item cadastrado com sucesso!');
            return redirect()->route('admin.copa04.edit', [$COPA04ContentPages->id]);
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o item1');
            return redirect()->back();
        }
    }

    public function edit(COPA04ContentPagesTopicItem $COPA04ContentPagesTopicItem)
    {
        return view('Admin.cruds.ContentPages.COPA04.Topics.edit', [
            'COPA04ContentPagesTopicItem' => $COPA04ContentPagesTopicItem,
            'cropSetting' => getCropImage('ContentPages', 'COPA04')
        ]);
    }

    public function update(Request $request, COPA04ContentPagesTopicItem $COPA04ContentPagesTopicItem)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($COPA04ContentPagesTopicItem, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($COPA04ContentPagesTopicItem, 'path_image');
            $data['path_image'] = null;
        }

        if($COPA04ContentPagesTopicItem->fill($data)->save()){
            $COPA04ContentPages = COPA04ContentPages::first();
            Session::flash('success', 'Item atualizado com sucesso!');
            return redirect()->route('admin.copa04.edit', [$COPA04ContentPages->id]);
        }else{
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar item!');
            return redirect()->back();
        }
    }

    public function destroy(COPA04ContentPagesTopicItem $COPA04ContentPagesTopicItem)
    {
        storageDelete($COPA04ContentPagesTopicItem, 'path_image');

        if($COPA04ContentPagesTopicItem->delete()){
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

        $COPA04ContentPagesTopicItems = COPA04ContentPagesTopicItem::whereIn('id', $request->deleteAll)->get();
        foreach($COPA04ContentPagesTopicItems as $COPA04ContentPagesTopicItem){
            storageDelete($COPA04ContentPagesTopicItem, 'path_image');
        }
        

        if($deleted = COPA04ContentPagesTopicItem::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
        }
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id){
            COPA04ContentPagesTopicItem::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContentPages\COPA04ContentPagesTopicItem  $COPA04ContentPagesTopicItem
     * @return \Illuminate\Http\Response
     */
    //public function show(COPA04ContentPagesTopicItem $COPA04ContentPagesTopicItem)
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
