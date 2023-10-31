<?php

namespace App\Http\Controllers\Galleries;

use App\Models\Galleries\GALL01Galleries;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class GALL01Controller extends Controller
{

    protected $path = 'uploads/Galleries/GALL01/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = GALL01Galleries::sorting()->paginate(15);

        return view('Admin.cruds.Galleries.GALL01.index', [
            'images' => $images
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Galleries.GALL01.create');
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

        $path_image =  $helper->uploadMultipleImage($request, 'path_image', $this->path, null,100);

        foreach ($path_image as $image) {
            $data['path_image'] = $image;
            GALL01Galleries::create($data);
        }

        return Response::json(['status' => 'success', 'countUploads' => COUNT($path_image)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Galleries\GALL01Galleries  $GALL01Galleries
     * @return \Illuminate\Http\Response
     */
    public function destroy(GALL01Galleries $GALL01Galleries)
    {
        storageDelete($GALL01Galleries, 'path_image');

        if($GALL01Galleries->delete()){
            Session::flash('success', 'Item deletado com sucessso');
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

        $GALL01Galleriess = GALL01Galleries::whereIn('id', $request->deleteAll)->get();
        foreach($GALL01Galleriess as $GALL01Galleries){
            storageDelete($GALL01Galleries, 'path_image');
        }

        if($deleted = GALL01Galleries::whereIn('id', $request->deleteAll)->delete()){
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
            GALL01Galleries::where('id', $id)->update(['sorting' => $sorting]);
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
        $images = GALL01Galleries::sorting()->get();

        return view('Client.pages.Galleries.GALL01.section', [
            'images' => $images
        ]);
    }
}
