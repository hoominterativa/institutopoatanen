<?php

namespace App\Http\Controllers\Teams;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Teams\TEAM01Teams;
use App\Http\Controllers\Controller;
use App\Models\Teams\TEAM01TeamsBanner;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Teams\TEAM01TeamsSection;
use Illuminate\Support\Facades\Response;
use App\Models\Teams\TEAM01TeamsCategory;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class TEAM01Controller extends Controller
{
    protected $path = 'uploads/Teams/TEAM01/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = TEAM01Teams::sorting()->paginate(20);
        $teamsCategories = TEAM01TeamsCategory::sorting()->paginate(20);
        $categories = TEAM01TeamsCategory::exists()->sorting()->pluck('title', 'id');
        $section = TEAM01TeamsSection::first();
        $banner = TEAM01TeamsBanner::first();
        return view('Admin.cruds.Teams.TEAM01.index', [
            'teams' => $teams,
            'teamsCategories' => $teamsCategories,
            'categories' => $categories,
            'section' => $section,
            'banner' => $banner,
            'cropSetting' => getCropImage('Teams', 'TEAM01')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = TEAM01TeamsCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Teams.TEAM01.create', [
            'categories' => $categories,
            'cropSetting' => getCropImage('Teams', 'TEAM01')
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
        $data['slug'] = $request->subtitle?Str::slug($request->title.'-'.$request->subtitle):Str::slug($request->title);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;

        if(TEAM01Teams::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.team01.index');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teams\TEAM01Teams  $TEAM01Teams
     * @return \Illuminate\Http\Response
     */
    public function edit(TEAM01Teams $TEAM01Teams)
    {
        $categories = TEAM01TeamsCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Teams.TEAM01.edit', [
            'team' => $TEAM01Teams,
            'categories' => $categories,
            'cropSetting' => getCropImage('Teams', 'TEAM01')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teams\TEAM01Teams  $TEAM01Teams
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TEAM01Teams $TEAM01Teams)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = $request->subtitle?Str::slug($request->title.'-'.$request->subtitle):Str::slug($request->title);

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($TEAM01Teams, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($TEAM01Teams, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box){
            storageDelete($TEAM01Teams, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($TEAM01Teams, 'path_image_box');
            $data['path_image_box'] = null;
        }

        if($TEAM01Teams->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teams\TEAM01Teams  $TEAM01Teams
     * @return \Illuminate\Http\Response
     */
    public function destroy(TEAM01Teams $TEAM01Teams)
    {
        storageDelete($TEAM01Teams, 'path_image_icon');
        storageDelete($TEAM01Teams, 'path_image_box');

        if($TEAM01Teams->delete()){
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

        $TEAM01Teamss = TEAM01Teams::whereIn('id', $request->deleteAll)->get();
        foreach($TEAM01Teamss as $TEAM01Teams){
            storageDelete($TEAM01Teams, 'path_image_icon');
            storageDelete($TEAM01Teams, 'path_image_box');
        }

        if($deleted = TEAM01Teams::whereIn('id', $request->deleteAll)->delete()){
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
            TEAM01Teams::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Teams\TEAM01Teams  $TEAM01Teams
     * @return \Illuminate\Http\Response
     */
    //public function show(TEAM01Teams $TEAM01Teams)
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
