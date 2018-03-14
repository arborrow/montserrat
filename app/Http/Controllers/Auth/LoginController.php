<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite; 
use App\AuthenticateUser;
use Symfony\Component\HttpFoundation\Request;
//use Illuminate\Support\Facades\Session;

// use Redirect; 
use Auth; 

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
        $user = Socialite::driver('google')->user();
        if (isset($user->user['domain'])) {
            if ($user->user['domain']=='montserratretreat.org') {
                $authuser = new \App\UserRepository;
                $currentuser = $authuser->findByUserNameOrCreate($user);
                Auth::login($currentuser, true);
                return redirect()->intended('/welcome');
                //return $this->userHasLoggedIn($currentuser);
                
            } else {
                // dd('Oops, wrong domain!');
               return redirect('restricted');
            }
            
        } else { 
            // dd('Oops, no domain!');
            return redirect('restricted');
        
        }
        // $user->token;
    }
    public function logout(AuthenticateUser $authenticateUser, Request $request, $provider = 'google')
    {
        Auth::logout();
        return redirect('/goodbye');
    }
    
}
