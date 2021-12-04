<?php

namespace App\Http\Controllers\Services;

use App\Models\Services\SERV01SectionServices;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;

class SERV01SectionController extends Controller
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
        $SERV01SectionServices = new SERV01SectionServices();
        $SERV01SectionServices->title = $request->title;
        $SERV01SectionServices->description = $request->description;
        $SERV01SectionServices->active = $request->active?:0;

        if($SERV01SectionServices->save()){
            Session::flash('success', 'Seção cadastrada com sucessso');
            return redirect()->route('admin.serv01.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV01SectionServices  $SERV01SectionServices
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV01SectionServices $SERV01SectionServices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV01SectionServices  $SERV01SectionServices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV01SectionServices $SERV01SectionServices)
    {
        $SERV01SectionServices->title = $request->title;
        $SERV01SectionServices->description = $request->description;
        $SERV01SectionServices->active = $request->active?:0;

        if($SERV01SectionServices->save()){
            Session::flash('success', 'Seção atualizada com sucessso');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV01SectionServices  $SERV01SectionServices
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV01SectionServices $SERV01SectionServices)
    {
        if($SERV01SectionServices->delete()){
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
        if($deleted = SERV01SectionServices::whereIn('id', $request->deleteAll)->delete()){
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
            SERV01SectionServices::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Services\SERV01SectionServices  $SERV01SectionServices
     * @return \Illuminate\Http\Response
     */
    public function show(SERV01SectionServices $SERV01SectionServices)
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
        return view('');
    }
}
