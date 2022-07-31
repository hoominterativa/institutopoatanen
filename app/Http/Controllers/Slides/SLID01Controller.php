<?php

namespace App\Http\Controllers\Slides;

use App\Models\Slides\SLID01Slides;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class SLID01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* Use the code below to upload files, if not, delete code

        $path = 'uploads/images/Module/Code/';
        $helperArchive = new HelperArchive();

        ** Duplicate the code below for each file field by changing the variable names **

        $path_image = $helperArchive->renameArchiveUpload($request, 'path_image');

        // Use this for normal image upload
        if($path_image){
            $SLID01Slides->path_image = $path.$path_image;
            $request->path_image->storeAs($path, $path_image);
        }

        // Use this one for image upload with cropping
        if(is_array($path_image)){
            $SLID01Slides->path_image = $path.$path_image[1];
            Storage::put($path.$path_image[1], base64_decode($path_image[0]));
        }

        */

        if($SLID01Slides->save()){
            Session::flash('success', 'Item cadastrado com sucessso');
            return redirect()->route('admin.code.index');
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
        //
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
        /* Use the code below to upload files, if not, delete code

        $path = 'uploads/images/Module/Code/';
        $helperArchive = new HelperArchive();

        ** Duplicate the code below for each file field by changing the variable names **
        ** Reference field to delete image: delete_name_input

        $path_image = $helperArchive->renameArchiveUpload($request, 'path_image');


        if(isset($request->delete_path_image) && !$path_image){
            $inputFile = $request->delete_path_image;
            Storage::delete($SLID01Slides->$inputFile);
            $SLID01Slides->path_image = null;
        }

        // Use this for normal image upload
        if($path_image){
            Storage::delete($SLID01Slides->path_image);
            $SLID01Slides->path_image = $path.$path_image;
            $request->path_image->storeAs($path, $path_image);
        }

        // Use this one for image upload with cropping
        if(is_array($path_image)){
            Storage::delete($SLID01Slides->path_image);
            $SLID01Slides->path_image = $path.$path_image[1];
            Storage::put($path.$path_image[1], base64_decode($path_image[0]));
        }

        */

        if($SLID01Slides->save()){
            Session::flash('success', 'Item atualizado com sucessso');
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
        if($SLID01Slides->delete()){
            Session::flash('success', 'Item deletado com sucessso');
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
        if($deleted = SLID01Slides::whereIn('id', $request->deleteAll)->delete()){
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
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Module', 'Model');

        return view('Client.pages.Module.Model.page',[
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
        return view('');
    }
}
