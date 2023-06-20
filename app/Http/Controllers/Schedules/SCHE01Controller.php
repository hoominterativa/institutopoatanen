<?php

namespace App\Http\Controllers\Schedules;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Schedules\SCHE01Schedules;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SCHE01Controller extends Controller
{
    protected $path = 'uploads/Schedules/SCHE01/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = SCHE01Schedules::sorting()->get();
        return view('Admin.cruds.Schedules.SCHE01.index', [
            'schedules' => $schedules,
            'cropSetting' => getCropImage('Schedules', 'SCHE01')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Schedules.SCHE01.create', [
            'cropSetting' => getCropImage('Schedules', 'SCHE01')
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
        $data['event_date'] = Carbon::createFromFormat('d/m/Y', $request->event_date)->format('Y-m-d');

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_sub = $helper->optimizeImage($request, 'path_image_sub', $this->path, null,100);
        if($path_image_sub) $data['path_image_sub'] = $path_image_sub;

        $path_image_hours = $helper->optimizeImage($request, 'path_image_hours', $this->path, null,100);
        if($path_image_hours) $data['path_image_hours'] = $path_image_hours;

        if (SCHE01Schedules::create($data)) {
            Session::flash('success', 'Agenda cadastrada com sucesso');
            return redirect()->route('admin.sche01.index');
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_hours);
            Storage::delete($path_image_sub);
            Session::flash('error', 'Erro ao cadastradar à agenda');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedules\SCHE01Schedules  $SCHE01Schedules
     * @return \Illuminate\Http\Response
     */
    public function edit(SCHE01Schedules $SCHE01Schedules)
    {
        $SCHE01Schedules->event_date = Carbon::parse($SCHE01Schedules->event_date)->format('d/m/Y');
        return view('Admin.cruds.Schedules.SCHE01.edit', [
            'schedule' =>  $SCHE01Schedules,
            'cropSetting' => getCropImage('Schedules', 'SCHE01')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedules\SCHE01Schedules  $SCHE01Schedules
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SCHE01Schedules $SCHE01Schedules)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['event_date'] = Carbon::createFromFormat('d/m/Y', $request->publishing)->format('Y-m-d');

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SCHE01Schedules, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SCHE01Schedules, 'path_image');
            $data['path_image'] = null;
        }

        //Hours icon
        $path_image_hours = $helper->optimizeImage($request, 'path_image_hours', $this->path, null,100);
        if($path_image_hours){
            storageDelete($SCHE01Schedules, 'path_image_hours');
            $data['path_image_hours'] = $path_image_hours;
        }
        if($request->delete_path_image_hours && !$path_image_hours){
            storageDelete($SCHE01Schedules, 'path_image_hours');
            $data['path_image_hours'] = null;
        }

        //Subtitle icon
        $path_image_sub = $helper->optimizeImage($request, 'path_image_sub', $this->path, null,100);
        if($path_image_sub){
            storageDelete($SCHE01Schedules, 'path_image_sub');
            $data['path_image_sub'] = $path_image_sub;
        }
        if($request->delete_path_image_sub && !$path_image_sub){
            storageDelete($SCHE01Schedules, 'path_image_sub');
            $data['path_image_sub'] = null;
        }


        if ($SCHE01Schedules->fill($data)->save()) {
            Session::flash('success', 'Agenda atualizada com sucesso');
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_hours);
            Storage::delete($path_image_sub);
            Session::flash('error', 'Erro ao atualizar à agenda');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedules\SCHE01Schedules  $SCHE01Schedules
     * @return \Illuminate\Http\Response
     */
    public function destroy(SCHE01Schedules $SCHE01Schedules)
    {
        storageDelete($SCHE01Schedules, 'path_image');
        storageDelete($SCHE01Schedules, 'path_image_hours');
        storageDelete($SCHE01Schedules, 'path_image_sub');

        if ($SCHE01Schedules->delete()) {
            Session::flash('success', 'agenda deletada com sucessso');
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
        $SCHE01Scheduless = SCHE01Schedules::whereIn('id', $request->deleteAll)->get();
        foreach($SCHE01Scheduless as $SCHE01Schedules){
            storageDelete($SCHE01Schedules, 'path_image');
            storageDelete($SCHE01Schedules, 'path_image_hours');
            storageDelete($SCHE01Schedules, 'path_image_sub');
        }

        if ($deleted = SCHE01Schedules::whereIn('id', $request->deleteAll)->delete()) {
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
            SCHE01Schedules::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Schedules\SCHE01Schedules  $SCHE01Schedules
     * @return \Illuminate\Http\Response
     */
    //public function show(SCHE01Schedules $SCHE01Schedules)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Schedules', 'SCHE01', 'show');

        return view('Client.pages.Schedules.SCHE01.show', [
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Schedules', 'SCHE01', 'page');

        return view('Client.pages.Schedules.SCHE01.page', [
            'sections' => $sections
        ]);
    }
}
