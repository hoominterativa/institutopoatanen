<?php

namespace App\Http\Controllers;

use App\Models\Optimization;
use App\Http\Controllers\Controller;
use App\Models\OptimizePage;
use Illuminate\Http\Request;

class OptimizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $optimization = Optimization::first();
        $optimizePages = OptimizePage::all();
        return view('Admin.cruds.Optimization.index',[
            'optimization' => $optimization,
            'optimizePages' => $optimizePages
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Optimization  $optimization
     * @return \Illuminate\Http\Response
     */
    public function show(Optimization $optimization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Optimization  $optimization
     * @return \Illuminate\Http\Response
     */
    public function edit(Optimization $optimization)
    {
        return view('Admin.cruds.Optimization.edit', [
            'optimization' => $optimization
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Optimization  $optimization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Optimization $optimization)
    {
        $optimization->author = $request->author;
        $optimization->title = $request->title;
        $optimization->description = $request->description;
        $optimization->keywords = $request->keywords;
        $optimization->scripts = $request->scripts;
        $optimization->other_scripts = $request->other_scripts;

        if($optimization->save()){
            $request->session()->flash('success', 'Informações atualizadas com sucesso');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Optimization  $optimization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Optimization $optimization)
    {
        //
    }
}
