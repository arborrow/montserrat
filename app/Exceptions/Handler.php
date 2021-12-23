<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Spatie\GoogleCalendar\Exceptions\InvalidConfiguration;

use Throwable;

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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     * TODO: Shift detected direct Mail::send() calls. Laravel 5.4 introduced Mailables which better encapsulate the code for sending emails.
     */
    public function render($request, Throwable $exception)
    {
        $mailable = 0; //initialize to false
        $subject = 'Error Detected on '.config('polanco.site_name');
        $fullurl = $request->fullUrl();
        (isset(Auth::User()->name) ? $username = Auth::User()->name : $username = 'Unknown user');
        (! empty($request->ip()) ? $ip_address = $request->ip() : $ip_address = 'Unspecified IP Address');

        //403
        if ($exception instanceof AuthorizationException) {
            $mailable = 1;
            $subject = '403 '.$subject.': ('.$username.') '.$fullurl;
        }

        // 404
        if ($exception instanceof NotFoundHttpException) {
            $mailable = 1;
            $subject = '404 '.$subject.': '.$fullurl;
        }

        // 500
        if ($exception instanceof \ErrorException || ($exception->getMessage() == "Google Calendar Error")) {
            $mailable = 1;
            $subject = '500 '.$subject.': '.$exception->getMessage();
        }


        // Do not actually mail if we are not in production
        if ($mailable && App::environment()=='production') {
            Mail::send('emails.en_US.error', ['error' => $exception, 'url' => $fullurl, 'user' => $username, 'ip' => $ip_address, 'subject' => $subject], function ($m) use ($subject, $exception, $request) {
                $m->to(config('polanco.admin_email'))->subject($subject);
            });
            flash('Email sent to site administrator regarding: '.$subject)->error();

        }

        if (($exception instanceof \ErrorException) && (! config('app.debug'))) { // avoid displaying error details to the user unless debugging
            abort(500);
        }

        return parent::render($request, $exception);
    }
}
