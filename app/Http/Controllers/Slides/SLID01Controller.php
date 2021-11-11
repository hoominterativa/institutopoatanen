<?php

namespace App\Http\Controllers\Slides;

use Illuminate\Http\Request;
use App\Models\Slides\SLID01Slides;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;

class SLID01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slides = SLID01Slides::paginate('12');
        return view('Admin.cruds.Slides.SLID01.index',[
            'slides' => $slides
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Slides.SLID01.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = 'uploads/images/SLID01/';
        $helperArchive = new HelperArchive();
        $path_image_background = $helperArchive->renameArchiveUpload($request, 'path_image_background');
        $path_image_png = $helperArchive->renameArchiveUpload($request, 'path_image_png');


        $SLID01Slides = new SLID01Slides();
        $SLID01Slides->title = $request->title;
        $SLID01Slides->subtitle = $request->subtitle;
        $SLID01Slides->description = $request->description;
        $SLID01Slides->blade = $request->blade;
        $SLID01Slides->content_position = $request->content_position;
        $SLID01Slides->active = $request->active?:0;
        $SLID01Slides->button_link = $request->button_link;
        $SLID01Slides->button_title = $request->button_title;

        if($path_image_background){
            $SLID01Slides->path_image_background = $path.$path_image_background;
            $request->path_image_background->storeAs($path, $path_image_background);
        }

        if($path_image_png){
            $SLID01Slides->path_image_png = $path.$path_image_png;
            $request->path_image_png->storeAs($path, $path_image_png);
        }

        if($SLID01Slides->save()){
            Session::flash('success', 'Banner cadastrado com sucessso');
            return redirect()->route('admin.slid01.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slides\SLID01Slides  $SLID01Slides
     * @return \Illuminate\Http\Response
     */
    public function edit(SLID01Slides $SLID01Slides)
    {
        return view('Admin.cruds.Slides.SLID01.edit',[
            'slide' => $SLID01Slides
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slides\SLID01Slides  $SLID01Slides
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SLID01Slides $SLID01Slides)
    {
        $path = 'uploads/images/SLID01/';
        $helperArchive = new HelperArchive();
        $path_image_background = $helperArchive->renameArchiveUpload($request, 'path_image_background');
        $path_image_png = $helperArchive->renameArchiveUpload($request, 'path_image_png');

        $SLID01Slides->title = $request->title;
        $SLID01Slides->subtitle = $request->subtitle;
        $SLID01Slides->description = $request->description;
        $SLID01Slides->blade = $request->blade;
        $SLID01Slides->content_position = $request->content_position;
        $SLID01Slides->active = $request->active?:0;
        $SLID01Slides->button_link = $request->button_link;
        $SLID01Slides->button_title = $request->button_title;

        if($path_image_background){
            Storage::delete($SLID01Slides->path_image_background);
            $SLID01Slides->path_image_background = $path.$path_image_background;
            $request->path_image_background->storeAs($path, $path_image_background);
        }

        if($path_image_png){
            Storage::delete($SLID01Slides->path_image_png);
            $SLID01Slides->path_image_png = $path.$path_image_png;
            $request->path_image_png->storeAs($path, $path_image_png);
        }

        if($SLID01Slides->save()){
            Session::flash('success', 'Banner atualizado com sucessso');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slides\SLID01Slides  $SLID01Slides
     * @return \Illuminate\Http\Response
     */
    public function destroy(SLID01Slides $SLID01Slides)
    {
        Storage::delete($SLID01Slides->path_image_background);
        Storage::delete($SLID01Slides->path_image_png);

        if($SLID01Slides->delete()){
            Session::flash('success', 'Banner deletado com sucessso');
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
        $SLID01Slides = SLID01Slides::whereIn('id', $request->deleteAll)->get();

        foreach ($SLID01Slides as $SLID01Slide) {
            Storage::delete($SLID01Slide->path_image_background);
            Storage::delete($SLID01Slide->path_image_png);
        }

        if($deleted = $SLID01Slides->delete()){
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
            SLID01Slides::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Slides\SLID01Slides  $SLID01Slides
     * @return \Illuminate\Http\Response
     */
    public function show(SLID01Slides $SLID01Slides)
    {
        //
    }

    /**
     * Display a listing of the resource.
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
        $SLID01Slides = SLID01Slides::where('active', 1)->get();
        return view('Client.pages.Slides.SLID01.section',[
            'slides'=>$SLID01Slides
        ]);
    }
}
