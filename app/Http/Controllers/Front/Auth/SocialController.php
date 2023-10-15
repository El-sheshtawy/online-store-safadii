<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function index($provider)
    {
        $user = Auth::user();

       $providerUser = Socialite::driver($provider)->userFromToken($user->provider_token);
       dd($providerUser);
    }
}
