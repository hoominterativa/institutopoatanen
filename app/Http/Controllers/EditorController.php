<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;

class EditorController extends Controller
{
    protected $path = 'uploads/editor/';

    public function upload(Request $request)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $upload = $helper->optimizeImage($request, 'upload', $this->path);
        if($upload) $data['upload'] = $upload;

        return Response::json([
            'default' => asset('storage/'.$data['upload'])
        ]);
    }
}
