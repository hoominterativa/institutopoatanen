<?php

namespace App\Http\Controllers\Feedbacks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Feedbacks\FEED06Feedbacks;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Feedbacks\FEED01FeedbacksSection;
use App\Models\Feedbacks\FEED06FeedbacksSection;
use App\Http\Controllers\IncludeSectionsController;

class FEED06Controller extends Controller
{
    protected $path = 'uploads/Feedbacks/FEED06/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedbacks = FEED06Feedbacks::sorting()->get();
        $section = FEED06FeedbacksSection::first();
        return view('Admin.cruds.Feedbacks.FEED06.index', [
            'feedbacks' => $feedbacks,
            'section' => $section,
            'cropSetting' => getCropImage('Feedbacks', 'FEED06')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Feedbacks.FEED06.create');
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

        if (FEED06Feedbacks::create($data)) {
            Session::flash('success', 'Depoimento cadastrado com sucesso');
            return redirect()->route('admin.feed06.index');
        } else {
            Session::flash('error', 'Erro ao cadastradar o depoimento');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedbacks\FEED06Feedbacks  $FEED06Feedbacks
     * @return \Illuminate\Http\Response
     */
    public function edit(FEED06Feedbacks $FEED06Feedbacks)
    {
        return view('Admin.cruds.Feedbacks.FEED06.edit', [
            'feedback' => $FEED06Feedbacks
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedbacks\FEED06Feedbacks  $FEED06Feedbacks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FEED06Feedbacks $FEED06Feedbacks)
    {
        $data = $request->all();

        $data['active'] = $request->active?1:0;

        if ($FEED06Feedbacks->fill($data)->save()) {
            Session::flash('success', 'Depoimento atualizado com sucesso');
        } else {
            Session::flash('error', 'Erro ao atualizar depoimento');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedbacks\FEED06Feedbacks  $FEED06Feedbacks
     * @return \Illuminate\Http\Response
     */
    public function destroy(FEED06Feedbacks $FEED06Feedbacks)
    {

        if ($FEED06Feedbacks->delete()) {
            Session::flash('success', 'Depoimento deletado com sucessso');
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

        if ($deleted = FEED06Feedbacks::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' Depoimentos deletados com sucessso']);
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
            FEED06Feedbacks::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT


    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        switch(deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $section = FEED06FeedbacksSection::active()->first();
                if($section) {
                    $section->path_image_desktop = $section->path_image_mobile;
                }
            break;
            default:
            $section = FEED06FeedbacksSection::active()->first();
            break;
        }

        $feedbacks = FEED06Feedbacks::active()->sorting()->get();
        return view('Client.pages.Feedbacks.FEED06.section', [
            'feedbacks' => $feedbacks,
            'section' => $section
        ]);
    }
}
