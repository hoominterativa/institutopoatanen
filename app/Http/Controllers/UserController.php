<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\SettingTheme;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id','!=', Auth::guard('web')->user()->id)->paginate('20');
        return view('Admin.cruds.User.index',[
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.User.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'email' => 'unique:users',
            'password' => 'min:8',
        ],[
            'password.min' => 'Míninmo de 8 cracteres para a senha',
            'email.unique' => 'E-mail já cadastrado no sistema'
        ]);

        $data = $request->all();
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', 'uploads/images/user/', null,100);

        if($path_image) $data['path_image'] = $path_image;

        $data['password'] = Hash::make($request->password);
        $data['active'] = $request->active?:0;

        if($user = User::create($data)){

            SettingTheme::create([
                'user_id' => $user->id,
                'color_scheme_mode' => 'dark',
                'leftsidebar_color' => 'dark',
                'leftsidebar_size' => 'default',
                'topbar_color' => 'dark',
            ]);

            Session::flash('success', 'Usuário cadastrado com sucesso');
            return redirect()->route('admin.user.index');
        }else{
            Storage::delete($path_image);
            Session::flash('success', 'Erro ao cadastradar o usuário');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('Admin.cruds.user.edit',[
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', 'uploads/images/user/', null,100);

        if($path_image){
            storageDelete($user, 'path_image');
            $data['path_image'] = $path_image;
        }

        if($request->delete_path_image && !$path_image){
            storageDelete($user, 'path_image');
            $data['path_image'] = null;
        }

        $data['password'] = Hash::make($request->password);
        $data['active'] = $request->active?:0;

        if($request->password == '') unset($data['password']);

        if($user->fill($data)->save()){
            Session::flash('success', 'Usuário atualizado com sucesso');
            return redirect()->route('admin.user.index');
        }else{
            Storage::delete($path_image);
            Session::flash('success', 'Erro ao atualizar os dados do usuário');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        SettingTheme::where('user_id', $user->id)->delete();

        storageDelete($user, 'path_image');
        if($user->delete()){
            Session::flash('success', 'Usuário deletado com sucesso');
            return redirect()->route('admin.user.index');
        }
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteSelected(Request $request)
    {
        $users = User::whereIn('id', $request->deleteAll)->get();
        foreach($users as $user){
            SettingTheme::where('user_id', $user->id)->delete();
            storageDelete($user, 'path_image');
        }

        if($deleted = User::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' usuários deletados com sucessso']);
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
            User::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
