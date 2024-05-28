<?php

namespace App\Http\Controllers\Schedules;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Schedules\SCHE01Schedules;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Schedules\SCHE01SchedulesContact;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Schedules\SCHE01SchedulesSection;

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
        $section = SCHE01SchedulesSection::first();
        $compliances = getCompliance(null, 'id', 'title_page');
        $contact = SCHE01SchedulesContact::first();
        $configForm = null;
        if ($contact) {
            $configForm = $contact->inputs_form ? json_decode($contact->inputs_form) : [];
        }
        return view('Admin.cruds.Schedules.SCHE01.index', [
            'schedules' => $schedules,
            'section' => $section,
            'compliances' => $compliances,
            'contact' => $contact,
            'configForm' => !is_array($configForm) ? $configForm : null,
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

        $data['active'] = $request->active ? 1 : 0;
        $data['active_banner'] = $request->active_banner ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;
        $data['event_date'] = Carbon::createFromFormat('d/m/Y', $request->event_date)->format('Y-m-d');
        if ($request->title || $request->subtitle) $data['slug'] = Str::slug($request->title . ' ' . ($request->subtitle ? $request->subtitle : ''));

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) $data['path_image'] = $path_image;

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null, 100);
        if ($path_image_box) $data['path_image_box'] = $path_image_box;

        $path_image_sub = $helper->optimizeImage($request, 'path_image_sub', $this->path, null, 100);
        if ($path_image_sub) $data['path_image_sub'] = $path_image_sub;

        $path_image_hours = $helper->optimizeImage($request, 'path_image_hours', $this->path, null, 100);
        if ($path_image_hours) $data['path_image_hours'] = $path_image_hours;

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null,100);
        if($path_image_desktop_banner) $data['path_image_desktop_banner'] = $path_image_desktop_banner;

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null,100);
        if($path_image_mobile_banner) $data['path_image_mobile_banner'] = $path_image_mobile_banner;

        if ($schedule = SCHE01Schedules::create($data)) {
            Session::flash('success', 'Agenda cadastrada com sucesso');
            return redirect()->route('admin.sche01.edit', ['SCHE01Schedules' => $schedule->id]);
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_box);
            Storage::delete($path_image_hours);
            Storage::delete($path_image_sub);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
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

        $data['active'] = $request->active ? 1 : 0;
        $data['active_banner'] = $request->active_banner ? 1 : 0;
        $data['featured'] = $request->featured ? 1 : 0;
        $data['event_date'] = Carbon::createFromFormat('d/m/Y', $request->event_date)->format('Y-m-d');
        if ($request->title || $request->subtitle) $data['slug'] = Str::slug($request->title . ' ' . ($request->subtitle ? $request->subtitle : ''));

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) {
            storageDelete($SCHE01Schedules, 'path_image');
            $data['path_image'] = $path_image;
        }
        if ($request->delete_path_image && !$path_image) {
            storageDelete($SCHE01Schedules, 'path_image');
            $data['path_image'] = null;
        }

        //Hours icon
        $path_image_hours = $helper->optimizeImage($request, 'path_image_hours', $this->path, null, 100);
        if ($path_image_hours) {
            storageDelete($SCHE01Schedules, 'path_image_hours');
            $data['path_image_hours'] = $path_image_hours;
        }
        if ($request->delete_path_image_hours && !$path_image_hours) {
            storageDelete($SCHE01Schedules, 'path_image_hours');
            $data['path_image_hours'] = null;
        }

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null, 100);
        if ($path_image_box) {
            storageDelete($SCHE01Schedules, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if ($request->delete_path_image_box && !$path_image_box) {
            storageDelete($SCHE01Schedules, 'path_image_box');
            $data['path_image_box'] = null;
        }

        //Subtitle icon
        $path_image_sub = $helper->optimizeImage($request, 'path_image_sub', $this->path, null, 100);
        if ($path_image_sub) {
            storageDelete($SCHE01Schedules, 'path_image_sub');
            $data['path_image_sub'] = $path_image_sub;
        }
        if ($request->delete_path_image_sub && !$path_image_sub) {
            storageDelete($SCHE01Schedules, 'path_image_sub');
            $data['path_image_sub'] = null;
        }

        $path_image_desktop_banner = $helper->optimizeImage($request, 'path_image_desktop_banner', $this->path, null, 100);
        if ($path_image_desktop_banner) {
            storageDelete($SCHE01Schedules, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = $path_image_desktop_banner;
        }
        if ($request->delete_path_image_desktop_banner && !$path_image_desktop_banner) {
            storageDelete($SCHE01Schedules, 'path_image_desktop_banner');
            $data['path_image_desktop_banner'] = null;
        }

        $path_image_mobile_banner = $helper->optimizeImage($request, 'path_image_mobile_banner', $this->path, null, 100);
        if ($path_image_mobile_banner) {
            storageDelete($SCHE01Schedules, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = $path_image_mobile_banner;
        }
        if ($request->delete_path_image_mobile_banner && !$path_image_mobile_banner) {
            storageDelete($SCHE01Schedules, 'path_image_mobile_banner');
            $data['path_image_mobile_banner'] = null;
        }


        if ($SCHE01Schedules->fill($data)->save()) {
            Session::flash('success', 'Agenda atualizada com sucesso');
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_box);
            Storage::delete($path_image_hours);
            Storage::delete($path_image_sub);
            Storage::delete($path_image_desktop_banner);
            Storage::delete($path_image_mobile_banner);
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
        storageDelete($SCHE01Schedules, 'path_image_box');
        storageDelete($SCHE01Schedules, 'path_image_hours');
        storageDelete($SCHE01Schedules, 'path_image_sub');
        storageDelete($SCHE01Schedules, 'path_image_desktop_banner');
        storageDelete($SCHE01Schedules, 'path_image_mobile_banner');

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
        foreach ($SCHE01Scheduless as $SCHE01Schedules) {

            storageDelete($SCHE01Schedules, 'path_image');
            storageDelete($SCHE01Schedules, 'path_image_box');
            storageDelete($SCHE01Schedules, 'path_image_hours');
            storageDelete($SCHE01Schedules, 'path_image_sub');
            storageDelete($SCHE01Schedules, 'path_image_desktop_banner');
            storageDelete($SCHE01Schedules, 'path_image_mobile_banner');
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
    public function show(SCHE01Schedules $SCHE01Schedules)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Schedules', 'SCHE01', 'show');

        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($SCHE01Schedules) {
                    $SCHE01Schedules->path_image_desktop_banner = $SCHE01Schedules->path_image_mobile_banner;
                }
            break;
        }

        $contact = SCHE01SchedulesContact::active()->first();
        $compliance = getCompliance($contact->compliance_id ?? '0');

        $monthlyEventCounts = SCHE01Schedules::select(
            DB::raw('MONTH(event_date) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->active()
            ->groupBy('month')
            ->pluck('count', 'month');

        return view('Client.pages.Schedules.SCHE01.show', [
            'sections' => $sections,
            'schedule' => $SCHE01Schedules,
            'contact' => $contact,
            'compliance' => $compliance,
            'inputs' => $contact ? (json_decode($contact->inputs_form) ?? []) : [],
            'monthlyEventCounts' => $monthlyEventCounts
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, $month = null)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Schedules', 'SCHE01', 'page');

        $section = SCHE01SchedulesSection::sorting()->first();
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if ($section) {
                    $section->path_image_desktop_banner = $section->path_image_mobile_banner;
                }
            break;

        }

        $contact = SCHE01SchedulesContact::active()->first();
        $compliance = getCompliance($contact->compliance_id ?? '0');
        $schedules = SCHE01Schedules::active();
        if ($month) {
            $schedules = $schedules->whereRaw('MONTH(event_date) = ' . $month);
        }
        $schedules = $schedules->sorting()->paginate(2);

        $monthlyEventCounts = SCHE01Schedules::select(
            DB::raw('MONTH(event_date) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->active()
            ->groupBy('month')
            ->pluck('count', 'month');

        return view('Client.pages.Schedules.SCHE01.page', [
            'sections' => $sections,
            'contact' => $contact,
            'compliance' => $compliance,
            'inputs' => $contact ? (json_decode($contact->inputs_form) ?? []) : [],
            'section' => $section,
            'schedules' => $schedules,
            'monthlyEventCounts' => $monthlyEventCounts
        ]);
    }

    public static function section()
    {
        $schedules = SCHE01Schedules::active()->sorting()->get();
        $section = SCHE01SchedulesSection::active()->sorting()->first();
        return view('Client.pages.Schedules.SCHE01.section',[
            'schedules' => $schedules,
            'section' => $section
        ]);
    }
}
