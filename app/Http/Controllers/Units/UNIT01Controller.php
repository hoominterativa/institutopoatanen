<?php

namespace App\Http\Controllers\Units;

use Illuminate\Http\Request;
use App\Models\Units\UNIT01Units;
use App\Http\Controllers\Controller;
use App\Models\Units\UNIT01UnitsTopic;
use App\Models\Units\UNIT01UnitsBanner;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Units\UNIT01UnitsGallery;

class UNIT01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = UNIT01Units::sorting()->get();
        $banner = UNIT01UnitsBanner::first();
        return view('Admin.cruds.Units.UNIT01.index', [
            'units' => $units,
            'banner' => $banner,
            'cropSetting' => getCropImage('Units', 'UNIT01')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Units.UNIT01.create');
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

        $data['active'] = $request->active?1:0;

        if(UNIT01Units::create($data)){
            Session::flash('success', 'Unidade cadastrada com sucesso');
            return redirect()->route('admin.unit01.index');
        }else{
            Session::flash('success', 'Erro ao cadastradar a unidade');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Units\UNIT01Units  $UNIT01Units
     * @return \Illuminate\Http\Response
     */
    public function edit(UNIT01Units $UNIT01Units)
    {
        $topics = UNIT01UnitsTopic::where('unit_id', $UNIT01Units->id)->sorting()->get();
        $galleries = UNIT01UnitsGallery::where('unit_id', $UNIT01Units->id)->sorting()->get();
        return view('Admin.cruds.Units.UNIT01.edit', [
            'unit' => $UNIT01Units,
            'topics' => $topics,
            'galleries' => $galleries,
            'cropSetting' => getCropImage('Units', 'UNIT01')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Units\UNIT01Units  $UNIT01Units
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UNIT01Units $UNIT01Units)
    {
        $data = $request->all();

        $data['active'] = $request->active?1:0;

        if($UNIT01Units->fill($data)->save()){
            Session::flash('success', 'Unidade atualizada com sucesso');
        }else{
            Session::flash('success', 'Erro ao atualizar a unidade');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Units\UNIT01Units  $UNIT01Units
     * @return \Illuminate\Http\Response
     */
    public function destroy(UNIT01Units $UNIT01Units)
    {
        $topics = UNIT01UnitsTopic::where('unit_id', $UNIT01Units->id)->get();
        foreach($topics as $topic){
            storageDelete($topic, 'path_image_icon');
            $topic->delete();
        }

        $galleries = UNIT01UnitsGallery::where('unit_id', $UNIT01Units->id)->get();
        foreach ($galleries as $gallery) {
            storageDelete($gallery, 'path_image');
            $gallery->delete();
        }

        if($UNIT01Units->delete()){
            Session::flash('success', 'Unidade deletada com sucessso');
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
        $UNIT01Units = UNIT01Units::whereIn('id', $request->deleteAll)->get();
        foreach($UNIT01Units as $UNIT01Unit){
            $topics = UNIT01UnitsTopic::where('unit_id', $UNIT01Unit->id)->get();
            foreach($topics as $topic){
                storageDelete($topic, 'path_image_icon');
                $topic->delete();
            }
            $galleries = UNIT01UnitsGallery::where('unit_id', $UNIT01Units->id)->get();
            foreach ($galleries as $gallery) {
                storageDelete($gallery, 'path_image');
                $gallery->delete();
            }
        }

        if($deleted = UNIT01Units::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Unidades deletadas com sucessso']);
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
            UNIT01Units::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Units\UNIT01Units  $UNIT01Units
     * @return \Illuminate\Http\Response
     */
    //public function show(UNIT01Units $UNIT01Units)
    public function show()
    {
        return view('Client.pages.Units.UNIT01.show');
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $banner = UNIT01UnitsBanner::active()->first();
                if($banner) $banner->path_image_desktop = $banner->path_image_mobile;
                break;
            default:
                $banner = UNIT01UnitsBanner::active()->first();
                break;
        }

        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Units', 'UNIT01');

        $units = UNIT01Units::with(['topics', 'galleries'])->active()->sorting()->get();

        return view('Client.pages.Units.UNIT01.page',[
            'sections' => $sections,
            'units' => $units,
            'banner' => $banner
        ]);
    }
}
