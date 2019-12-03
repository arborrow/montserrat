<?php

namespace App\Http\Controllers\Auth;

use App\AuthenticateUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Symfony\Component\HttpFoundation\Request;

//use Illuminate\Support\Facades\Session;

// use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $socialite_restrict_domain = env('SOCIALITE_RESTRICT_DOMAIN');
        // dd($socialite_retrict_domain,$user);
        if (isset($socialite_restrict_domain)) {
            if (isset($user->user['hd'])) {
                if ($user->user['hd'] == $socialite_restrict_domain) { // the user domain matches the social restrict domain so authenticate successfully
                    $authuser = new \App\UserRepository;
                    $currentuser = $authuser->findByUserNameOrCreate($user);
                    Auth::login($currentuser, true);

                    return redirect()->intended('/welcome');
                //return $this->userHasLoggedIn($currentuser);
                } else { // the user has a domain but it does not match the socialite restrict domain so do not authenticate
                    return redirect('restricted');
                }
            } else { // no domain specified for the user but one is required so do not authenticate
                return redirect('restricted');
            }
        } else { // not using socialite restrict domain - all domains can authenticate
            $authuser = new \App\UserRepository;
            $currentuser = $authuser->findByUserNameOrCreate($user);
            Auth::login($currentuser, true);

            return redirect('welcome');
        }
    }

    public function logout(AuthenticateUser $authenticateUser, Request $request, $provider = 'google')
    {
        Auth::logout();

        return redirect('/goodbye');
    }
}
