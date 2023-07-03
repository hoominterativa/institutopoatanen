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
use App\Models\Teams\TEAM01TeamsSectionTeam;
use App\Models\Teams\TEAM01TeamsSocialMedia;

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
        $sectionTeam = TEAM01TeamsSectionTeam::first();
        return view('Admin.cruds.Teams.TEAM01.index', [
            'teams' => $teams,
            'teamsCategories' => $teamsCategories,
            'categories' => $categories,
            'section' => $section,
            'banner' => $banner,
            'sectionTeam' => $sectionTeam,
            'cropSetting' => getCropImage('Teams', 'TEAM01')
        ]);
    }

    public function filter(Request $request)
    {
        Session::put('filter.category_id', $request->category_id);
        Session::put('filter.title', $request->title);
        Session::put('filter.subtitle', $request->subtitle);
        Session::put('filter.active', $request->active);
        Session::put('filter.featured', $request->featured);
        Session::save();

        $teams = TEAM01Teams::with('category');

        if($request->category_id){
            $teams = $teams->where('category_id', Session::get('filter.category_id'));
        }
        if($request->title){
            $teams = $teams->where('title','LIKE', '%'.Session::get('filter.title').'%');
        }
        if($request->subtitle){
            $teams = $teams->where('subtitle','LIKE', '%'.Session::get('filter.subtitle').'%');
        }

        if(Session::get('filter.active')=='1'){
            $teams = $teams->where('active', 1);
        }
        if(Session::get('filter.active')=='0'){
            $teams = $teams->where('active', 0);
        }
        if(Session::get('filter.featured')){
            $teams = $teams->where('featured', 1);
        }


        $teams = TEAM01Teams::with('category')->sorting()->paginate(20);
        $teamsCategories = TEAM01TeamsCategory::sorting()->paginate(20);
        $categories = TEAM01TeamsCategory::exists()->sorting()->pluck('title', 'id');
        $section = TEAM01TeamsSection::first();
        $banner = TEAM01TeamsBanner::first();
        $sectionTeam = TEAM01TeamsSectionTeam::first();

        return view('Admin.cruds.Teams.TEAM01.index',[
            'teams' => $teams,
            'categories' => $categories,
            'teamsCategories' => $teamsCategories,
            'section' => $section,
            'banner' => $banner,
            'sectionTeam' => $sectionTeam,
            'cropSetting' => getCropImage('Teams', 'TEAM01')
        ]);
    }

    public function clearFilter()
    {
        Session::forget('filter');
        return redirect()->route('admin.team01.index');
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

        if($team = TEAM01Teams::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.team01.edit', ['TEAM01Teams' => $team->id]);
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
        $socials = TEAM01TeamsSocialMedia::where('team_id', $TEAM01Teams->id)->sorting()->get();
        return view('Admin.cruds.Teams.TEAM01.edit', [
            'team' => $TEAM01Teams,
            'categories' => $categories,
            'socials' => $socials,
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
        $socials = TEAM01TeamsSocialMedia::where('team_id', $TEAM01Teams->id)->get();
        foreach($socials as $social) {
            storageDelete($social, 'path_image_icon');
            $social->delete();
        }

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
            $socials = TEAM01TeamsSocialMedia::where('team_id', $TEAM01Teams->id)->get();
            foreach($socials as $social) {
                storageDelete($social, 'path_image_icon');
                $social->delete();
            }

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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Teams', 'TEAM01', 'show');

        return view('Client.pages.Teams.TEAM01.show',[
            'sections' => $sections
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, TEAM01TeamsCategory $TEAM01TeamsCategory)
    {
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $banner = TEAM01TeamsBanner::active()->first();
                if($banner) $banner->path_image_desktop = $banner->path_image_mobile;
                break;
            default:
                $banner = TEAM01TeamsBanner::active()->first();
                break;
        }

        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Teams', 'TEAM01', 'page');

        $categories = TEAM01TeamsCategory::active()->exists()->sorting()->get();
        $sectionTeam = TEAM01TeamsSectionTeam::active()->first();  
        $teams = TEAM01Teams::with(['socials' => function ($query) {$query->where('active', 1);}])->active();


        if($TEAM01TeamsCategory->exists){
            $teams = $teams->where('category_id', $TEAM01TeamsCategory->id);

            foreach ($categories as $category) {
                if($TEAM01TeamsCategory->id==$category->id){
                    $category->selected = true;
                }
            }
        }

        $teams = $teams->sorting()->get();

        return view('Client.pages.Teams.TEAM01.page',[
            'sections' => $sections,
            'banner' => $banner,
            'categories' => $categories,
            'teams' => $teams,
            'sectionTeam' => $sectionTeam
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $section = TEAM01TeamsSection::active()->first();
        $teams = TEAM01Teams::with(['socials' => function ($query) {$query->where('active', 1);}])->active()->featured()->sorting()->get();

        return view('Client.pages.Teams.TEAM01.section', [
            'section' => $section,
            'teams' => $teams
        ]);
    }
}
