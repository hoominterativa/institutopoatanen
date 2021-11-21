<?php

namespace App\Http\Controllers\Topics;

use Illuminate\Http\Request;
use App\Models\Topics\TOPI01Topics;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Topics\TOPI01SectionTopics;
use App\Http\Controllers\Helpers\HelperArchive;

class TOPI01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $TOPI01Topics = TOPI01Topics::sorting()->paginate('15');
        $TOPI01SectionTopics = TOPI01SectionTopics::first();

        return view('Admin.cruds.Topics.TOPI01.index',[
            'topics'=>$TOPI01Topics,
            'topicSection'=>$TOPI01SectionTopics
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Topics.TOPI01.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = 'uploads/images/Topics/TOPI01/';
        $helperArchive = new HelperArchive();
        $path_image = $helperArchive->renameArchiveUpload($request, 'path_image');

        $TOPI01Topics = new TOPI01Topics();
        $TOPI01Topics->title = $request->title;
        $TOPI01Topics->description = $request->description;
        $TOPI01Topics->active = $request->active?:0;

        if(is_array($path_image)){
            $TOPI01Topics->path_image = $path.$path_image[1];
            Storage::put($path.$path_image[1], base64_decode($path_image[0]));
        }

        if($TOPI01Topics->save()){
            Session::flash('success', 'Tópico cadastrado com sucessso');
            return redirect()->route('admin.topi01.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topics\TOPI01Topics  $TOPI01Topics
     * @return \Illuminate\Http\Response
     */
    public function edit(TOPI01Topics $TOPI01Topics)
    {
        return view('Admin.cruds.Topics.TOPI01.edit', [
            'topic'=>$TOPI01Topics
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topics\TOPI01Topics  $TOPI01Topics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TOPI01Topics $TOPI01Topics)
    {
        $path = 'uploads/images/Topics/TOPI01/';
        $helperArchive = new HelperArchive();
        $path_image = $helperArchive->renameArchiveUpload($request, 'path_image');

        $TOPI01Topics->title = $request->title;
        $TOPI01Topics->description = $request->description;
        $TOPI01Topics->active = $request->active?:0;

        if(isset($request->delete_path_image) && !$path_image){
            $inputFile = $request->delete_path_image;
            Storage::delete($TOPI01Topics->$inputFile);
            $TOPI01Topics->path_image = null;
        }

        if(is_array($path_image)){
            Storage::delete($TOPI01Topics->path_image);
            $TOPI01Topics->path_image = $path.$path_image[1];
            Storage::put($path.$path_image[1], base64_decode($path_image[0]));
        }

        if($TOPI01Topics->save()){
            Session::flash('success', 'Tópico atualizado com sucessso');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topics\TOPI01Topics  $TOPI01Topics
     * @return \Illuminate\Http\Response
     */
    public function destroy(TOPI01Topics $TOPI01Topics)
    {
        Storage::delete($TOPI01Topics->path_image);

        if($TOPI01Topics->delete()){
            Session::flash('success', 'Tópico deletado com sucessso');
            return redirect()->back();
        }
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request)
    {
        if($deleted = TOPI01Topics::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' tópicos deletados com sucessso']);
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
            TOPI01Topics::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Topics\TOPI01Topics  $TOPI01Topics
     * @return \Illuminate\Http\Response
     */
    public function show(TOPI01Topics $TOPI01Topics)
    {
        //
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        //
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $TOPI01Topics = TOPI01Topics::sorting()->get();
        $TOPI01SectionTopics = TOPI01SectionTopics::first();
        return view('Client.pages.Topics.TOPI01.section',[
            'topics'=>$TOPI01Topics,
            'topicSection'=>$TOPI01SectionTopics
        ]);
    }
}
