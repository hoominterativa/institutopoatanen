<?php

namespace App\Http\Controllers;

use App\Models\Social;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;

class SocialController extends Controller
{
    protected $path = 'uploads/social/images/';

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
        // $social = new Social();
        // $social->title = $request->title;
        // $social->link = $request->link;
        // $social->path_image_icon = $request->path_image_icon;
        // $social->save();

        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        if(Social::create($data)){
            Session::flash('success', 'Item cadastrado com sucessso');
            return redirect(Session::previousUrl().'#rowSocial');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
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
        // $Social->title = $request->title;
        // $Social->link = $request->link;
        // $Social->path_image_icon = $request->path_image_icon;
        // $Social->save();

        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon){
            storageDelete($Social, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($Social, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        if($Social->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucessso');
            return redirect(Session::previousUrl().'#rowSocial');
        }else{
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao atualizar o item');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Social  $Social
     * @return \Illuminate\Http\Response
     */
    public function destroy(Social $Social)
    {
        storageDelete($Social, 'path_image');
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
        $socials = Social::whereIn('id', $request->deleteAll)->get();
        foreach($socials as $social){
            storageDelete($social, 'path_image_icon');
        }

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
