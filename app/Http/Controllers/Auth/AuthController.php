<?php

namespace montserrat\Http\Controllers\Auth;

use montserrat\User;
use montserrat\AuthenticateUser;
use montserrat\UserRepository; 
use Validator;
use montserrat\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Socialite;
use Illuminate\Http\Request;
use Auth; 
use Session;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
     /**
     * Redirect the user to the Google authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }
    
    /**
     * Obtain the user information from Google.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return Redirect::to('login/google');
        }

        //dd($user);
        $authuser = new \montserrat\UserRepository;
        $currentuser = $authuser->findByUserNameOrCreate($user);
        //dd($currentuser);
       //$this->auth->login($user, true);
       Auth::login($currentuser, true);
       return $this->userHasLoggedIn($currentuser);
        // return redirect('/');
        // echo $user->name.' ('.$user->email.') is logged in';

        // $user->token;
    }
    
    public function login(AuthenticateUser $authenticateUser, Request $request, $provider = 'google') 
    {
       //dd($provider); 
       return $authenticateUser->execute($request->all(), $this, $provider);
    }
    public function logout(AuthenticateUser $authenticateUser, Request $request, $provider = 'google') 
    {
        Auth::logout();
        return redirect('/');
    }
    
    public function userHasLoggedIn($user) 
    {
    //    dd($user);
    Session::flash('message', 'Welcome, ' . $user->username);
    return redirect('/');
    }
}
