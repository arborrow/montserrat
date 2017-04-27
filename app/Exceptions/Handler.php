<?php

namespace montserrat\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use montserrat\Mail\WebError;
// use Illuminate\Http\Request;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        //dd($exception); 
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    /* public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
    */
    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
    
    public function render($request, Exception $e)
    {   
        // check for validation exception
        if ($e instanceof ValidationException && $e->getResponse()) {
            return $e->getResponse();
        }
         
        $fullurl = $request->fullUrl();
        if (isset(Auth::User()->name)) {
            $username = Auth::User()->name;
        } else {
            $username = 'Unknown user';
        }
        
        // dd($request->user(), Auth::user(), $username);
        $ip_address = 'Unspecified IP Address';
        if (!empty($request->ip())) {
            $ip_address = $request->ip();
        }
        
        /* check for authentication exception
         * user will be redirected to (Google) login page
         * will alert me to when an unauthenticated user tries to access secured content
         */
        if ($e instanceof AuthenticationException) {
            $web_error = array();
            $web_error['subject'] = 'Polanco Authentication Error @ '.$fullurl.' by: '.$username.' from: '.$ip_address;
            $web_error['body'] = $this->convertExceptionToResponse($e);
            Mail::to(['address' => config('polanco.admin_email')])
                ->send(new WebError($web_error));
                
            return $this->unauthenticated($request, $e);
        }
        
        /* check for 403 error
         * user will be redirected to 403 error page (banned)
         * will alert me to when an authenticated user tries to access content not intended for them
         * generally this means that a link has not been checked with a 'can' check
         * I prefer to not give the user the option to do things they are not supposed to do
         */
        if ($e instanceof AuthorizationException) {
                $web_error = array();
                $web_error['subject'] = 'Polanco 403 Error @ '.$fullurl.' by: '.$username.' from: '.$ip_address;
                $web_error['body'] = $this->convertExceptionToResponse($e);
                
                Mail::to(['address' => config('polanco.admin_email')])
                        ->send(new WebError($web_error));
                $e = new HttpException(403, $e->getMessage());
                parent::render($request, $e);
        } 
        /* check for 404 error
         * user will be redirected to 404 error page (St. Anthony not found)
         * will alert me to bad links or bad user input to non-existing routes or records
         */
        if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException)  {
                $e = new NotFoundHttpException($e->getMessage(), $e);
                $web_error = array();
                $web_error['subject'] = 'Polanco 404 Error @ '.$fullurl.' by: '.$username.' from: '.$ip_address;
                $web_error['body'] = $this->convertExceptionToResponse($e);
                Mail::to(['address' => config('polanco.admin_email')])
                        ->send(new WebError($web_error));
                parent::render($request, $e);
        }
        /* check for 500 error
         * user will be redirected to 500 error page (Jason Bourne)
         * alerts me to pages with internal/code errors - usually undefined variables
         */
        $e->debug=true;
        if ($e instanceof \ErrorException) {
            $web_error = array();
            $web_error['subject'] = 'Polanco 500 Error @ '.$fullurl.' by: '.$username.' from: '.$ip_address;
            $web_error['body'] = $this->convertExceptionToResponse($e);
            Mail::to(['address' => config('polanco.admin_email')])
                        ->send(new WebError($web_error));
            parent::render($request, $e);
            return view('errors.default');
        
        } else {
            if ($this->isHttpException($e)) {
                return $this->toIlluminateResponse($this->renderHttpException($e), $e);
            } else {
                return $this->toIlluminateResponse($this->convertExceptionToResponse($e), $e);
            }
        }
    }
}
