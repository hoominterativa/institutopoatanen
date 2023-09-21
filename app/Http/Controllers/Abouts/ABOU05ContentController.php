<?php

namespace App\Http\Controllers\Abouts;

use App\Models\Abouts\ABOU05AboutsContent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Abouts\ABOU05AboutsSocial;

class ABOU05ContentController extends Controller
{
    protected $path = 'uploads/Abouts/ABOU05/images/';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Admin.cruds.Abouts.ABOU05.Content.create",[
            'cropSetting' => getCropImage('Abouts', 'ABOU05')
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

        $path_image_inner = $helper->optimizeImage($request, 'path_image_inner', $this->path, null,100);
        if($path_image_inner) $data['path_image_inner'] = $path_image_inner;

        if($content = ABOU05AboutsContent::create($data)){
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.abou05.content.edit', ['ABOU05AboutsContent' => $content->id]);
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_inner);
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Abouts\ABOU05AboutsContent  $ABOU05AboutsContent
     * @return \Illuminate\Http\Response
     */
    public function edit(ABOU05AboutsContent $ABOU05AboutsContent)
    {
        $socials = ABOU05AboutsSocial::where('content_id', $ABOU05AboutsContent->id)->get();
        return view("Admin.cruds.Abouts.ABOU05.Content.edit",[
            'content' => $ABOU05AboutsContent,
            'socials' => $socials,
            'cropSetting' => getCropImage('Abouts', 'ABOU05')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abouts\ABOU05AboutsContent  $ABOU05AboutsContent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ABOU05AboutsContent $ABOU05AboutsContent)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($ABOU05AboutsContent, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($ABOU05AboutsContent, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_inner = $helper->optimizeImage($request, 'path_image_inner', $this->path, null,100);
        if($path_image_inner){
            storageDelete($ABOU05AboutsContent, 'path_image_inner');
            $data['path_image_inner'] = $path_image_inner;
        }
        if($request->delete_path_image_inner && !$path_image_inner){
            storageDelete($ABOU05AboutsContent, 'path_image_inner');
            $data['path_image_inner'] = null;
        }

        if($ABOU05AboutsContent->fill($data)->save()){
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_inner);
            Session::flash('error', 'Erro ao atualizar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Abouts\ABOU05AboutsContent  $ABOU05AboutsContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(ABOU05AboutsContent $ABOU05AboutsContent)
    {
        $socials = ABOU05AboutsSocial::where('content_id', $ABOU05AboutsContent->id)->get();
        if ($socials) {
            foreach ($socials as $social){
                storageDelete($social, 'path_image');
                $social->delete();
            }
        }
        storageDelete($ABOU05AboutsContent, 'path_image');
        storageDelete($ABOU05AboutsContent, 'path_image_inner');

        if($ABOU05AboutsContent->delete()){
            Session::flash('success', 'Conteúdo deletado com sucessso');
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

        $ABOU05AboutsContents = ABOU05AboutsContent::whereIn('id', $request->deleteAll)->get();
        foreach($ABOU05AboutsContents as $ABOU05AboutsContent){
            $socials = ABOU05AboutsSocial::where('content_id', $ABOU05AboutsContent->id)->get();
            if ($socials) {
                foreach ($socials as $social){
                    storageDelete($social, 'path_image');
                    $social->delete();
                }
            }

            storageDelete($ABOU05AboutsContent, 'path_image');
            storageDelete($ABOU05AboutsContent, 'path_image_inner');
        }

        if($deleted = ABOU05AboutsContent::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' conteúdos deletados com sucessso']);
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
            ABOU05AboutsContent::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
