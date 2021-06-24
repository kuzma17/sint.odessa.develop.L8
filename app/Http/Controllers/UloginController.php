<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSocialAccount;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Image;
use Redirect;
use Session;

class UloginController extends Controller
{
    public function login(Request $request)
    {

        $data = file_get_contents('http://ulogin.ru/token.php?token='.$request->get('token').'&host='.$_SERVER['HTTP_HOST']);
        $user = json_decode($data, true);

        if (isset($user['email']) && !empty($user['email'])) {

            $userData = UserSocialAccount::where('provider_user_id', $user['uid'])
                ->where('provider', $user['network'])
                ->first();

            if ($userData) {
                Auth::loginUsingId($userData->user_id, true);
                Session::flash('ok_message', 'Успещная авторизация.');
                //return Redirect::back();
                return Redirect::route('user.profile');
            } else {

                if(User::where('email', $user['email'])->first()){
                    Session::flash('error_message', 'В базе уже есть аккаунт с email: '.$user['email'].' Попробуйте ввести другой.');
                    return Redirect::back();
                }else {
                    $newUser = User::create([
                        'name' => isset($user['nickname']) ? $user['nickname'] : $user['first_name'],
                        'email' => $user['email'],
                        'password' => Hash::make(str_random(8)),
                    ]);

                    if (isset($user['first_name']) || isset($user['last_name']) || isset($user['phone']) || isset($user['city'])) {
                        $user['last_name'] = isset($user['last_name']) ? $user['last_name'] : '';
                        $newUser->profile()->create([
                            'client_name' => $user['first_name'] . ' ' . $user['last_name'],
                            'phone' => isset($user['phone']) ? $user['phone'] : '',
                            'city' => isset($user['city']) ? $user['city'] : ''
                        ]);
                    }

                    if (isset($user['photo']) && $user['network'] != 'instagram') {

                        $imageName = str_random(10).'.jpg';
                        $tmp_img = '/tmp/'.$imageName;

                        file_put_contents($tmp_img, file_get_contents($user['photo']));

                        Image::make($tmp_img)->resize(160, 160)->save('upload/avatars/'.$imageName);

                        $newUser->avatar()->create([
                            'avatar' => 'avatars/'.$imageName
                        ]);

                    }

                    $newUser->socialAccount()->create([
                        'provider_user_id' => $user['uid'],
                        'provider' => $user['network']
                    ]);

                    Auth::loginUsingId($newUser->id, true);
                    Session::flash('ok_message', 'Успещная авторизация.');
                    //return Redirect::back();
                    return Redirect::route('user.profile');
                }
            }
        }
        Session::flash('error_message', 'Произошла ошибка.');
        return Redirect::back();
    }
}
