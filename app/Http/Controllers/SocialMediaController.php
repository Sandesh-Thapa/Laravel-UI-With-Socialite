<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class SocialMediaController extends Controller
{
    protected $acceptableProvider = ['google', 'facebook', 'github', 'linkedin', 'twitter'];

    public function redirectToProvider($provider){
        foreach($this->acceptableProvider as $social){
            if ($provider == $social){
                return Socialite::driver($provider)->redirect();
            }
        }
        return redirect('/login');
    }

    public function handleProviderCallback($provider){
        $user = Socialite::driver($provider)->user();
        $this->_registerOrLoginUser($user, $provider);
        return redirect()->route('home');
    }
   
    protected function registerUser($user, $data, $first_name, $last_name){
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->email = $data->email;
        $user->provider_id = $data->id;
        $user->avatar = $data->avatar;
        $user->save();
    }

    protected function _registerOrLoginUser($data, $provider) {
        $user = User::where('email', '=', $data->email)->first();
        if (!$user){
            $user = new User();
            switch ($provider){
                case 'google':
                    $this->registerUser($user, $data, $data->user["given_name"], $data->user["family_name"]);
                    break;

                case 'linkedin':
                    $this->registerUser($user, $data, $data->first_name, $data->last_name);
                    break;

                case 'github':
                    $fullname = $data->name;
                    $fullname = explode(' ', $fullname);
                    $last_name = "";
                    for ($i = 1; $i < count($fullname); $i++){
                        $last_name .= $fullname[$i] . " ";
                    }
                    $this->registerUser($user, $data, $fullname[0], $last_name);
                    break;

                case 'twitter':
                    $fullname = $data->name;
                    $fullname = explode(' ', $fullname);
                    $last_name = "";
                    for ($i = 1; $i < count($fullname); $i++){
                        $last_name .= $fullname[$i] . " ";
                    }
                    $this->registerUser($user, $data, $fullname[0], $last_name);
                    break;

                default:
                    return redirect()->route('home');
            }
        }

        Auth::login($user);
    }
}
