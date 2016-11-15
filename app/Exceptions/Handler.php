<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler {
	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		AuthorizationException::class,
		HttpException::class,
		ModelNotFoundException::class,
		ValidationException::class,
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e) {
		parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e) {

		// this line allows you to redirect to a route or even back to the current page if there is a CSRF Token Mismatch
		if ($e instanceof \Illuminate\Session\TokenMismatchException) {
			return redirect('/auth/login')->withErrors(['token_error' => 'Sorry, your session seems to have expired.']);
		}

		// let's add some support if a Model is not found
		// for example, if you were to run a query for User #10000 and that user didn't exist we can return a 404 error
		if ($e instanceof ModelNotFoundException) {
			return response()->view('errors.404', [], 404);
		}

		// Let's return a default error page instead of the ugly Laravel error page when we have fatal exceptions
		if ($e instanceof \symfony\debug\Exception\FatalErrorException) {
			return \Response::view('errors.500', [], 500);
		}

		// finally we are back to the original default error handling provided by Laravel
		if ($this->isHttpException($e)) {
			switch ($e->getStatusCode()) {
			// not found
			case 404:
				return \Response::view('errors.404', [], 404);
			// internal error
			case 500:
				return \Response::view('errors.500', [], 500);
			default:
				return $this->renderHttpException($e);
			}
		} else {
			return parent::render($request, $e);
		}
	}
}
