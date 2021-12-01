<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV01Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SERV01Controller extends Controller
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
            $SERV01Services->path_image = $path.$path_image;
            $request->path_image->storeAs($path, $path_image);
        }

        // Use this one for image upload with cropping
        if(is_array($path_image)){
            $SERV01Services->path_image = $path.$path_image[1];
            Storage::put($path.$path_image[1], base64_decode($path_image[0]));
        }

        */

        if($SERV01Services->save()){
            Session::flash('success', 'Item cadastrado com sucessso');
            return redirect()->route('admin.code.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV01Services  $SERV01Services
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV01Services $SERV01Services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV01Services  $SERV01Services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV01Services $SERV01Services)
    {
        /* Use the code below to upload files, if not, delete code

        $path = 'uploads/images/Module/Code/';
        $helperArchive = new HelperArchive();

        ** Duplicate the code below for each file field by changing the variable names **
        ** Reference field to delete image: delete_name_input

        $path_image = $helperArchive->renameArchiveUpload($request, 'path_image');


        if(isset($request->delete_path_image) && !$path_image){
            $inputFile = $request->delete_path_image;
            Storage::delete($SERV01Services->$inputFile);
            $SERV01Services->path_image = null;
        }

        // Use this for normal image upload
        if($path_image){
            Storage::delete($SERV01Services->path_image);
            $SERV01Services->path_image = $path.$path_image;
            $request->path_image->storeAs($path, $path_image);
        }

        // Use this one for image upload with cropping
        if(is_array($path_image)){
            Storage::delete($SERV01Services->path_image);
            $SERV01Services->path_image = $path.$path_image[1];
            Storage::put($path.$path_image[1], base64_decode($path_image[0]));
        }

        */

        if($SERV01Services->save()){
            Session::flash('success', 'Item atualizado com sucessso');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV01Services  $SERV01Services
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV01Services $SERV01Services)
    {
        if($SERV01Services->delete()){
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
        if($deleted = SERV01Services::whereIn('id', $request->deleteAll)->delete()){
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
            SERV01Services::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Services\SERV01Services  $SERV01Services
     * @return \Illuminate\Http\Response
     */
    public function show(SERV01Services $SERV01Services)
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
        return view('Client.pages.Services.SERV01.section');
    }
}
