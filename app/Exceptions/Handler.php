<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exception\HttpResponseException;
use Symfony\Component\Debug\Exception\FlattenException;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
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
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
         $fullurl = $request->fullUrl();
	 if (isset(Auth::User()->name)) {
	     $username = Auth::User()->name;
	 } else {
	     $username = 'Unknown user';
	 }
	 $ip_address = 'Unspecified IP Address';
	 if (!empty($request->ip())) {
	     $ip_address = $request->ip();
	 }
	 
	 /* 
	  * if ($exception instanceof ModelNotFoundException) {
	     $exception = new NotFoundHttpException($e->getMessage(), $e);
	 }

         if ($exception instanceof HttpResponseException) {
	     return $exception->getResponse();
	 } elseif ($exception instanceof NotFoundHttpException) {
		$exception = new NotFoundHttpException($exception->getMessage(), $exception);
		Mail::send('emails.error', ['error' => $this->convertExceptionToResponse($exception)], function ($message) use ($fullurl, $username, $ip_address) {
			$message->to(config('polanco.admin_email'));
			$message->subject('Polanco 404 Error @'.$fullurl.' by: '.$username.' from: '.$ip_address);
			$message->from(config('polanco.site_email'));
		});
	 } elseif ($exception instanceof AuthenticationException) {
		return $this->unauthenticated($request, $exception);
	 } elseif ($exception instanceof AuthorizationException) {
		$exception = new HttpException(403, $e->getMessage());
		Mail::send('emails.error', ['error' => $this->convertExceptionToResponse($exception)], function ($message) use ($fullurl, $username, $ip_address) {
			$message->to(config('polanco.admin_email'));
			$message->subject('Polanco 403 Error @'.$fullurl.' by: '.$username.' from: '.$ip_address);
			$message->from(config('polanco.site_email'));
		});
	} elseif ($exception instanceof ValidationException && $exception->getResponse()) {
		return $exception->getResponse();
	}

	$exception->debug=true;
	if ($this->isHttpException($exception)) {
		return $this->toIlluminateResponse($this->renderHttpException($exception), $exception);
	} else {
		Mail::send('emails.error', ['error' => $this->convertExceptionToResponse($exception)], function ($message) use ($fullurl, $username, $ip_address) {
			$message->to(config('polanco.admin_email'));
			$message->subject('Polanco Error @'.$fullurl.' by: '.$username.' from: '.$ip_address);
			$message->from(config('polanco.site_email'));
		});
	return view('errors.default');
	}	
	dd($request, $exception);
	  */ 
	return parent::render($request, $exception);
    }
}
