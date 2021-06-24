<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\TypeClient;
use App\Models\User;
use App\Models\UserAvatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->load('profile');
        return view('user.profile', ['user'=>$user]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user()->load('profile');
        $offices = Office::all();
        $type_clients = TypeClient::all();
        return view('user.edit_profile', [
            'user' => $user,
            'offices'=>$offices,
            'type_clients' => $type_clients
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $user->update($request->request->all());
        $data = $request->except(['_token', 'email']);
        $user->profile()->update($data);

        return redirect(route('user.profile'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function avatar(Request $request){
        $user = Auth::user();
        if($request->isMethod('post')) {

            $this->validate($request, [
                'avatar'  =>  'required|image|max:300',
            ]);
            $image = $request->file('avatar');

            Image::make($image->getRealPath())->resize(160, 160)->save();
            $saveImageName = \Illuminate\Support\Str::random(10) . '.' . $image->getClientOriginalExtension();
            if(UserAvatar::where('user_id', $user->id)->first()) {
                $avatar = UserAvatar::where('user_id', $user->id)->first();
            }else{
                $avatar = new UserAvatar();
            }

            $image->move('upload/avatars', $saveImageName);

            $avatar->user_id = $user->id;
            $avatar->avatar = 'avatars/'.$saveImageName;
            $avatar->save();

            session()->flash('ok_message', 'Ваш аватар успешно соxранен.');
            return redirect(route('user.profile'));
        }else{
            return view('user.edit_avatar');
        }
    }

    public function dell_avatar(){
        $user = Auth::user();
        UserAvatar::destroy($user->id);
        session()->flash('ok_message', 'Ваше фото успешно удалено.');
        return redirect(route('user.profile'));
    }

    public function edit_password(Request $request){
        if($request->isMethod('post')){
            $this->validate($request, [
                'old_password' => 'required|oldpassword',
                'password'  =>  'required|min:6|confirmed',
            ]);
            //if(Hash::check($request->old_password, Auth::user()->password)){
            $tek_user = User::find(Auth::id());
            $tek_user->password = Hash::make($request->password);
            $tek_user->save();
            session()->flash('ok_message', 'Ваш пароль успешно изменен.');
            return redirect(route('user.profile'));
            //}
        }else{
            return view('user.edit_password');
        }
    }
}
