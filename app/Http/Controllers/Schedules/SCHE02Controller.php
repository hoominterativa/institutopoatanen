<?php

namespace App\Http\Controllers\Schedules;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Schedules\SCHE02Schedules;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Schedules\SCHE02SchedulesSection;

class SCHE02Controller extends Controller
{
    protected $path = 'uploads/Schedules/SCHE02/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = SCHE02Schedules::sorting()->paginate(30);
        $section = SCHE02SchedulesSection::first();
        return view('Admin.cruds.Schedules.SCHE02.index',[
            'schedules' => $schedules,
            'section' => $section,
            'cropSetting' => getCropImage('Schedules', 'SCHE02')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Schedules.SCHE02.create',[
            'cropSetting' => getCropImage('Schedules', 'SCHE02')
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
        $date['link_button_one'] = isset($data['link_button_one']) ? getUri($data['link_button_one']) : null;
        $date['link_button_two'] = isset($data['link_button_two']) ? getUri($data['link_button_two']) : null;
        $data['event_date'] = Carbon::createFromFormat('d/m/Y', $request->event_date)->format('Y-m-d');

        if(SCHE02Schedules::create($data)){
            Session::flash('success', 'Evento cadastrado com sucesso');
            return redirect()->route('admin.sche02.index');
        }else{
            Session::flash('error', 'Erro ao cadastradar o evento');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedules\SCHE02Schedules  $SCHE02Schedules
     * @return \Illuminate\Http\Response
     */
    public function edit(SCHE02Schedules $SCHE02Schedules)
    {
        $SCHE02Schedules->event_date = Carbon::parse($SCHE02Schedules->event_date)->format('d/m/Y');
        return view('Admin.cruds.Schedules.SCHE02.edit', [
            'schedule' => $SCHE02Schedules,
            'cropSetting' => getCropImage('Schedules', 'SCHE02')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedules\SCHE02Schedules  $SCHE02Schedules
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SCHE02Schedules $SCHE02Schedules)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;
        $date['link_button_one'] = isset($data['link_button_one']) ? getUri($data['link_button_one']) : null;
        $date['link_button_two'] = isset($data['link_button_two']) ? getUri($data['link_button_two']) : null;
        $data['event_date'] = Carbon::createFromFormat('d/m/Y', $request->event_date)->format('Y-m-d');

        if($SCHE02Schedules->fill($data)->save()){
            Session::flash('success', 'Evento atualizado com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar o evento');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedules\SCHE02Schedules  $SCHE02Schedules
     * @return \Illuminate\Http\Response
     */
    public function destroy(SCHE02Schedules $SCHE02Schedules)
    {

        if($SCHE02Schedules->delete()){
            Session::flash('success', 'Evento deletado com sucessso');
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


        if($deleted = SCHE02Schedules::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Eventos deletados com sucessso']);
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
            SCHE02Schedules::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Schedules\SCHE02Schedules  $SCHE02Schedules
     * @return \Illuminate\Http\Response
     */
    //public function show(SCHE02Schedules $SCHE02Schedules)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Schedules', 'SCHE02', 'show');

        return view('Client.pages.Schedules.SCHE02.show',[
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Schedules', 'SCHE02', 'page');

        return view('Client.pages.Schedules.SCHE02.page',[
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
        $section = SCHE02SchedulesSection::first();
        $schedules = SCHE02Schedules::active()->featured()->sorting()->get();
        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($section) {
                    $section->path_image_desktop_section = $section->path_image_mobile_section;
                }
            break;
        }
        return view('Client.pages.Schedules.SCHE02.section', [
            'schedules' => $schedules,
            'section' => $section
        ]);
    }
}
