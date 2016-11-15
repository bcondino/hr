<?php

namespace App\Http\Controllers\Auth;

use App\Http\Classes\AutoSeed;
use App\Http\Controllers\Controller;
use App\tbl_company_model;
use App\tbl_user_company_model;
use App\tbl_user_type_model;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Mail;
use Redirect;
use Session;
use Validator;

class AuthController extends Controller {
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

	public $registerView = 'auth/register';
	public $loginView = 'auth/login';
	public $redirectAfterLogout = 'auth/login';
	public $maxLoginAttempts = 3;
	public $redirectTo = '/home';

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest', ['except' => ['logout', 'getLogout']]);
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data) {
		return Validator::make($data, [
			'first_name' => 'required'
			, 'last_name' => 'required'
			, 'email_address' => 'required|email|unique:tbl_user,email_address'
			, 'company_name' => 'required'
			,
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data) {
		$password = $this->rand_string();
		$user_types = new \App\tbl_user_type_model();
		$user_type_id = $user_types->where('user_type_name', '=', 'Super Admin')->first()->user_type_id;

		return User::create([
			'first_name' => $data['first_name']
			, 'last_name' => $data['last_name']
			, 'username' => $data['email_address']
			, 'email_address' => $data['email_address']
			, 'pwd' => $password
			, 'user_type_id' => $user_type_id
			, 'is_activated' => 'N'
			, 'status' => 'P'
			, 'is_first_logged' => 'Y'
			,
		]);
	}

	public function rand_string() {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < 8; $i++) {
			$str .= $chars[rand(0, strlen($chars) - 1)];
		}
		return $str;
	}

	public function getChangepassword2($user_id) {
		$auth = User::where('user_id', $user_id)->first();
		Auth::login($auth);
		$user = Auth::user();
		return view('auth.changepassword2', ['user' => $user]);
	}

	public function getResendverification($email_address) {
		$user = User::where('email_address', $email_address)->first();

		// check email verfication
		Mail::send('auth/verifyemail', $user->getAttributes(), function ($message) use ($email_address) {
			$message
				->to($email_address)
				->subject('Activate your NuvemHR account!');
		});

		return view('auth/verify', ['email_address' => $email_address]);
	}

	public function getActivateverification($email_address) {
		/* 20161019 update from Brian Condino
			- Reason: Initial company created should also be activate upon activation of user account
		*/

		User::where('email_address', '=', $email_address)
			->update(['is_activated' => 'Y'
				 , 'status' => 'A']);
		$user_id = User::where('email_address', '=', $email_address)->first()->user_id;
		tbl_company_model::where('company_id', tbl_user_company_model::where('user_id', $user_id)
				->first()
				->company_id)
				->update(
				['active_flag' => 'Y']
			);
		$company_id = tbl_company_model::find(tbl_user_company_model::where('user_id', $user_id)
				->first()->company_id)->company_id;

		/* 20161026 updated by Melvin Militante */
		$user_company = tbl_user_company_model::where('user_id', $user_id)->first();
		$autoSeed = new AutoSeed();
		$autoSeed->company_autoseed($user_company->company_id);
		/* 20161026 end of update */

		/* 20161019 end of update */
		return redirect('/');
	}

	public function getForgotpass() {
		return view('auth.forgotpass');
	}

	public function postForgotpass(Request $request) {
		// check email verfication
		Mail::send('auth.forgotemail'
			, User::
				where('is_activated', 'Y')
				->where('status', 'A')
				->where('username', $request->email)
				->first()
				->toArray()
			, function ($message) use ($request) {
				$message->to($request->email)->subject('NuvemHR account password reset!');
			});
		Session::flash('passwordreset', 'Your NuvemHR account was reset! Please see your email to change your password.');
		return redirect()->back();
	}

}
