<?php

namespace App\Http\Controllers\Contents;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Contents\CONT10V2Contents;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Contents\CONT10V2ContentsSection;
use App\Http\Controllers\IncludeSectionsController;

class CONT10V2Controller extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT10V2Contents::sorting()->paginate(15);
        $section = CONT10V2ContentsSection::first();
        return view('Admin.cruds.Contents.CONT10V2.index', [
            'contents' => $contents,
            'section' => $section,
            'cropSetting' => getCropImage('Contents', 'CONT10V2')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Contents.CONT10V2.create');
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

        $date['active'] = $request->active ? 1 : 0;
        $data['date'] = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        if (CONT10V2Contents::create($data)) {
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.cont10v2.index');
        } else {
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contents\CONT10V2Contents  $CONT10V2Contents
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT10V2Contents $CONT10V2Contents)
    {
        $CONT10V2Contents->date = Carbon::parse($CONT10V2Contents->date)->format('d/m/Y');
        return view('Admin.cruds.Contents.CONT10V2.edit', [
            'content' => $CONT10V2Contents
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT10V2Contents  $CONT10V2Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT10V2Contents $CONT10V2Contents)
    {
        $data = $request->all();

        $date['active'] = $request->active ? 1 : 0;
        $data['date'] = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
        $data['link'] = isset($data['link']) ? getUri($data['link']) : null;

        if ($CONT10V2Contents->fill($data)->save()) {
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        } else {
            Session::flash('error', 'Erro ao atualizar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT10V2Contents  $CONT10V2Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT10V2Contents $CONT10V2Contents)
    {
        if ($CONT10V2Contents->delete()) {
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
        if ($deleted = CONT10V2Contents::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' Conteúdos deletados com sucessso']);
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
            CONT10V2Contents::where('id', $id)->update(['sorting' => $sorting]);
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
                $section = CONT10V2ContentsSection::active()->first();
                if($section) $section->path_image_desktop = $section->path_image_mobile;
                break;
            default:
                $section = CONT10V2ContentsSection::active()->first();
                break;
        }

        $contents = CONT10V2Contents::active()->sorting()->get();
        return view('Client.pages.Contents.CONT10V2.section', [
            'contents' => $contents,
            'section' => $section
        ]);
    }
}
