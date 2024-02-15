<?php

namespace App\Http\Controllers\Feedbacks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Feedbacks\FEED05Feedbacks;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Feedbacks\FEED05FeedbacksSection;
use App\Http\Controllers\IncludeSectionsController;

class FEED05Controller extends Controller
{
    protected $path = 'uploads/Feedbacks/FEED05/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedbacks = FEED05Feedbacks::sorting()->get();
        $section = FEED05FeedbacksSection::first();
        return view('Admin.cruds.Feedbacks.FEED05.index', [
            'feedbacks' => $feedbacks,
            'section' => $section,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Feedbacks.FEED05.create', [
            'cropSetting' => getCropImage('Feedbacks', 'FEED05')
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

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        if (FEED05Feedbacks::create($data)) {
            Session::flash('success', 'Feedback cadastrado com sucesso');
            return redirect()->route('admin.feed05.index');
        } else {
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao cadastradar o feedback');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedbacks\FEED05Feedbacks  $FEED05Feedbacks
     * @return \Illuminate\Http\Response
     */
    public function edit(FEED05Feedbacks $FEED05Feedbacks)
    {
        return view('Admin.cruds.Feedbacks.FEED05.edit', [
            'feedback' => $FEED05Feedbacks,
            'cropSetting' => getCropImage('Feedbacks', 'FEED05')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedbacks\FEED05Feedbacks  $FEED05Feedbacks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FEED05Feedbacks $FEED05Feedbacks)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($FEED05Feedbacks, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($FEED05Feedbacks, 'path_image');
            $data['path_image'] = null;
        }

        if ($FEED05Feedbacks->fill($data)->save()) {
            Session::flash('success', 'Feedback atualizado com sucesso');
        } else {
            Storage::delete($path_image);
            Session::flash('error', 'Erro ao atualizar o feedback');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedbacks\FEED05Feedbacks  $FEED05Feedbacks
     * @return \Illuminate\Http\Response
     */
    public function destroy(FEED05Feedbacks $FEED05Feedbacks)
    {
        storageDelete($FEED05Feedbacks, 'path_image');

        if ($FEED05Feedbacks->delete()) {
            Session::flash('success', 'Feedback deletado com sucessso');
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

        $FEED05Feedbackss = FEED05Feedbacks::whereIn('id', $request->deleteAll)->get();
        foreach($FEED05Feedbackss as $FEED05Feedbacks){
            storageDelete($FEED05Feedbacks, 'path_image');
        }

        if ($deleted = FEED05Feedbacks::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' Feedbacks deletados com sucessso']);
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
            FEED05Feedbacks::where('id', $id)->update(['sorting' => $sorting]);
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
        $section = FEED05FeedbacksSection::active()->first();
        $feedbacks = FEED05Feedbacks::active()->sorting()->get();
        return view('Client.pages.Feedbacks.FEED05.section', [
            'section' => $section,
            'feedbacks' => $feedbacks
        ]);
    }
}
