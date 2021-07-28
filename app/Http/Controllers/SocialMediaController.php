<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class SocialMediaController extends Controller
{
    // Social media Auth login 
    // Google
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback () {
        $user = Socialite::driver('google')->user();
        $this->_registerOrLoginUser($user, 'google');
        return redirect()->route('home');
    }


    // Facebook
    public function redirectToFacebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback () {
        $user = Socialite::driver('facebook')->user();
        $this->_registerOrLoginUser($user, 'facebook');
        return redirect()->route('home');
    }


    // // Github
    public function redirectToGithub(){
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback () {
        $user = Socialite::driver('github')->user();
        $this->_registerOrLoginUser($user, 'github');
        return redirect()->route('home');
    }

    // Linkedin
    public function redirectToLinkedin(){
        return Socialite::driver('linkedin')->redirect();
    }

    public function handleLinkedinCallback () {
        $user = Socialite::driver('linkedin')->user();
        $this->_registerOrLoginUser($user, 'linkedin');
        return redirect()->route('home');
    }

    //twitter
    public function redirectToTwitter(){
        return Socialite::driver('twitter')->redirect();
    }

    public function handleTwitterCallback () {
        $user = Socialite::driver('twitter')->user();
        $this->_registerOrLoginUser($user, 'twitter');
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
                    for ($i=1; $i<count($fullname); $i++){
                        $last_name .= $fullname[$i] . " ";
                    }
                    $this->registerUser($user, $data, $fullname[0], $last_name);
                    break;

                case 'twitter':
                    $fullname = $data->name;
                    $fullname = explode(' ', $fullname);
                    $last_name = "";
                    for ($i=1; $i<count($fullname); $i++){
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
