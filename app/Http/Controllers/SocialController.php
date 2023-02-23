<?php

namespace App\Http\Controllers;

use App\Models\Social;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socials = Social::sorting()->get();
        return view('Admin.cruds.social.edit',[
            'socials' => $socials
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
        $social = new Social();
        $social->title = $request->title;
        $social->link = $request->link;
        $social->icon = $request->icon;
        $social->save();

        Session::flash('success', 'Item cadastrado com sucessso');
        return redirect(Session::previousUrl().'#rowSocial');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Social  $Social
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Social $Social)
    {
        $Social->title = $request->title;
        $Social->link = $request->link;
        $Social->icon = $request->icon;
        $Social->save();

        Session::flash('success', 'Item atualizado com sucessso');
        return redirect(Session::previousUrl().'#rowSocial');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Social  $Social
     * @return \Illuminate\Http\Response
     */
    public function destroy(Social $Social)
    {
        if($Social->delete()){
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
        if($deleted = Social::whereIn('id', $request->deleteAll)->delete()){
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
            Social::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
