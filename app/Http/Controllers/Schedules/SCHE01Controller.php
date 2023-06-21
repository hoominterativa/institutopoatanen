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
use App\Models\Schedules\SCHE01SchedulesBanner;
use App\Models\Schedules\SCHE01SchedulesContact;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Schedules\SCHE01SchedulesBannerShow;
use App\Models\Schedules\SCHE01SchedulesSectionSchedule;

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
        $banner = SCHE01SchedulesBanner::first();
        $sectionSchedule = SCHE01SchedulesSectionSchedule::first();
        $compliances = getCompliance(null, 'id', 'title_page');
        $contact = SCHE01SchedulesContact::first();
        $configForm = json_decode($contact->inputs_form ? $contact->inputs_form : []);
        return view('Admin.cruds.Schedules.SCHE01.index', [
            'schedules' => $schedules,
            'banner' => $banner,
            'sectionSchedule' => $sectionSchedule,
            'compliances' => $compliances,
            'contact' => $contact,
            'configForm' => !is_array($configForm)?$configForm:null,
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

        if ($schedule = SCHE01Schedules::create($data)) {
            Session::flash('success', 'Agenda cadastrada com sucesso');
            return redirect()->route('admin.sche01.edit', ['SCHE01Schedules' => $schedule->id]);
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
        $bannerShow = SCHE01SchedulesBannerShow::where('schedule_id', $SCHE01Schedules->id)->first();
        return view('Admin.cruds.Schedules.SCHE01.edit', [
            'schedule' =>  $SCHE01Schedules,
            'bannerShow' => $bannerShow,
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
        $bannerShow = SCHE01SchedulesBannerShow::where('schedule_id', $SCHE01Schedules->id)->first();
        if ($bannerShow) {
            storageDelete($bannerShow, 'path_image_desktop');
            storageDelete($bannerShow, 'path_image_mobile');
            $bannerShow->delete();
        }

        storageDelete($SCHE01Schedules, 'path_image');
        storageDelete($SCHE01Schedules, 'path_image_hours');
        storageDelete($SCHE01Schedules, 'path_image_sub');

        if ($SCHE01Schedules->delete()) {
            Session::flash('success', 'agenda deletada com sucesso');
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

            $bannerShow = SCHE01SchedulesBannerShow::where('schedule_id', $SCHE01Schedules->id)->first();
            if ($bannerShow) {
                storageDelete($bannerShow, 'path_image_desktop');
                storageDelete($bannerShow, 'path_image_mobile');
                $bannerShow->delete();
            }

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
