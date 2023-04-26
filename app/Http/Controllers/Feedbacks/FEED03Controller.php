<?php

namespace App\Http\Controllers\Feedbacks;

use App\Models\Feedbacks\FEED03Feedbacks;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Feedbacks\FEED03FeedbacksSection;

class FEED03Controller extends Controller
{
    protected $path = 'uploads/Feedbacks/FEED03/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedbacks = FEED03Feedbacks::sorting()->paginate(15);
        $section = FEED03FeedbacksSection::first();
        return view('Admin.cruds.Feedbacks.FEED03.index', [
            'feedbacks' => $feedbacks,
            'section' => $section,
            'cropSetting' => getCropImage('Feedbacks', 'FEED03')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Feedbacks.FEED03.create', [
            'cropSetting' => getCropImage('Feedbacks', 'FEED03')
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

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(FEED03Feedbacks::create($data)){
            Session::flash('success', 'Feedback cadastrado com sucesso');
            return redirect()->route('admin.feed03.index');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao cadastradar o feedback');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedbacks\FEED03Feedbacks  $FEED03Feedbacks
     * @return \Illuminate\Http\Response
     */
    public function edit(FEED03Feedbacks $FEED03Feedbacks)
    {
        return view('Admin.cruds.Feedbacks.FEED03.edit', [
            'feedback' => $FEED03Feedbacks,
            'cropSetting' => getCropImage('Feedbacks', 'FEED03')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedbacks\FEED03Feedbacks  $FEED03Feedbacks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FEED03Feedbacks $FEED03Feedbacks)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon){
            storageDelete($FEED03Feedbacks, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($FEED03Feedbacks, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($FEED03Feedbacks->fill($data)->save()){
            Session::flash('success', 'Feedback atualizado com sucesso');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao atualizar o feedback');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedbacks\FEED03Feedbacks  $FEED03Feedbacks
     * @return \Illuminate\Http\Response
     */
    public function destroy(FEED03Feedbacks $FEED03Feedbacks)
    {
        storageDelete($FEED03Feedbacks, 'path_image_icon');

        if($FEED03Feedbacks->delete()){
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
        $FEED03Feedbackss = FEED03Feedbacks::whereIn('id', $request->deleteAll)->get();
        foreach($FEED03Feedbackss as $FEED03Feedbacks){
            storageDelete($FEED03Feedbacks, 'path_image_icon');
        }

        if($deleted = FEED03Feedbacks::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Feedbacks deletados com sucessso']);
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
            FEED03Feedbacks::where('id', $id)->update(['sorting' => $sorting]);
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
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $section = FEED03FeedbacksSection::active()->first();
                if($section) $section->path_image_desktop = $section->path_image_mobile;
                break;
            default:
                $section = FEED03FeedbacksSection::active()->first();
                break;
        }

        $feedbacks = FEED03Feedbacks::active()->sorting()->get();
        return view('Client.pages.Feedbacks.FEED03.section', [
            'feedbacks' => $feedbacks,
            'section' => $section
        ]);
    }
}
