<?php

namespace montserrat\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exception\HttpResponseException;
use Symfony\Component\Debug\Exception\FlattenException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
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
         
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }
        
        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
            Mail::send('emails.error', ['error' => $this->convertExceptionToResponse($e)], function ($message) use ($fullurl, $username, $ip_address) {
                $message->to(config('polanco.admin_email'));
                $message->subject('Polanco 404 Error @'.$fullurl.' by: '.$username.' from: '.$ip_address);
                $message->from(config('polanco.site_email'));
            });
        } elseif ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        } elseif ($e instanceof AuthorizationException) {
            $e = new HttpException(403, $e->getMessage());
            Mail::send('emails.error', ['error' => $this->convertExceptionToResponse($e)], function ($message) use ($fullurl, $username, $ip_address) {
                $message->to(config('polanco.admin_email'));
                $message->subject('Polanco 403 Error @'.$fullurl.' by: '.$username.' from: '.$ip_address);
                $message->from(config('polanco.site_email'));
            });
        } elseif ($e instanceof ValidationException && $e->getResponse()) {
            return $e->getResponse();
        }
        
        $e->debug=true;
        if ($this->isHttpException($e)) {
            return $this->toIlluminateResponse($this->renderHttpException($e), $e);
        } else {
            Mail::send('emails.error', ['error' => $this->convertExceptionToResponse($e)], function ($message) use ($fullurl, $username, $ip_address) {
                $message->to(config('polanco.admin_email'));
                $message->subject('Polanco Error @'.$fullurl.' by: '.$username.' from: '.$ip_address);
                $message->from(config('polanco.site_email'));
            });
            return view('errors.default');
        }
    }
}
