<?php

namespace App\Http\Controllers\Portfolios;

use App\Models\Portfolios\PORT06PortfoliosCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class PORT06CategoryController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;


        if (PORT06PortfoliosCategory::create($data)) {
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->back();
        } else {
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    public function update(Request $request, PORT06PortfoliosCategory $PORT06PortfoliosCategory)
    {
        $data = $request->all();

        $data['active'] = $request->active ? 1 : 0;

        if ($PORT06PortfoliosCategory->fill($data)->save()) {
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->back();
        } else {
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    public function destroy(PORT06PortfoliosCategory $PORT06PortfoliosCategory)
    {
        if ($PORT06PortfoliosCategory->delete()) {
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }


    public function destroySelected(Request $request)
    {

        if ($deleted = PORT06PortfoliosCategory::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' itens deletados com sucessso']);
        }
    }


    public function sorting(Request $request)
    {
        foreach ($request->arrId as $sorting => $id) {
            PORT06PortfoliosCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
