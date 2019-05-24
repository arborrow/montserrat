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
use function GuzzleHttp\Promise\exception_for;

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
			$ip_address = 'Unspecified IP Address';
			$username = 'Unknown user';
			$subject =  'Error Detected on ' . config('polanco.site_name');

			if (isset(Auth::User()->name)) {
				$username = Auth::User()->name;
			}

			if (!empty($request->ip())) {
				$ip_address = $request->ip();
			}

			if (method_exists($exception, 'getStatusCode')) {
				$subject .= ' ' . $exception->getStatusCode();
			}

			Mail::send('emails.error', ['error' => $exception, 'url' => $fullurl, 'user' => $username, 'ip' => $ip_address], function ($m) use ($subject, $exception, $request) {
				$m->to(config('polanco.admin_email'))->subject($subject);
				return parent::render($request, $exception);
			});
			
			return parent::render($request, $exception);
		}
}
