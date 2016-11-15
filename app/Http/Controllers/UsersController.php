<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\tbl_user_company_model;
use App\User;
use Illuminate\Http\Request;
use Mail;
use Session;
use Validator;

class UsersController extends Controller {
	//
	public function getUsers() {
		$users = User::where('status', 'A')
			->where('user_id', '!=', $this->currentUser->user_id)
			->whereIn('user_id', tbl_user_company_model::
					where('company_id', $this->currentCompany->company_id)
					->lists('user_id')
					->toArray())
			->orderBy('last_name')
			->orderBy('first_name')
			->get();
		return view('main/admin/users', ['users' => $users, 'company' => $this->currentCompany]);
	}

	public function postUsers(Request $requests) {
		$add_user_rules = [
			'first_name' => 'required',
			'last_name' => 'required',
			'email_address' => 'required',
			'company_id' => 'required'];
		$add_user_msg = [
			'first_name.required' => 'First name is a required field.',
			'last_name.required' => 'Last name is a required field.',
			'email_address.required' => 'E-mail address is a required field.',
			'company_id.required' => 'Company name is a required field.'];
		$validator = Validator::make($requests->all(), $add_user_rules, $add_user_msg);
		if ($validator->fails()) {
			Session::flash('add-failed', 'Failed to add new user!');
			return redirect()->back()->withErrors($validator)->withInput();
		} else {

			$password = $this->rand_string();
			$user = User::create([
				'first_name' => $requests->first_name
				, 'last_name' => $requests->last_name
				, 'username' => $requests->email_address
				, 'email_address' => $requests->email_address
				, 'user_type_id' => $requests->user_type_id
				, 'pwd' => $password
				, 'is_activated' => 'N'
				, 'status' => 'A'
				, 'is_first_logged' => 'Y'
				, 'created_by' => $this->currentUser->user_id
				, 'updated_by' => $this->currentUser->user_id,
			]);

			tbl_user_company_model::create([
				'user_id' => $user->user_id
				, 'company_id' => $requests->company_id
				, 'default_flag' => 'Y'
				, 'created_by' => $this->currentUser->user_id
				, 'updated_by' => $this->currentUser->user_id,
			]);

			// check email verfication
			Mail::send('auth/verifyemail', $user->getAttributes(), function ($message) use ($requests) {
				$message
					->to($requests['email_address'])
					->subject('Activate your NuvemHR account!');
			});

			Session::flash('add-success', 'New user has been added successfully.');
			return redirect()->back();
		}
	}

	public function putUsers(Request $request) {

		if ($request->isDelete) {
			if (count($request->users) > 0) {
				foreach ($request->users as $user) {
					tbl_user_company_model::where('user_id', $user)->delete();
					User::find($user)->delete();
				}
				Session::flash('del-success', 'Records selected have been deleted successfully.');
				return redirect()->back();
			} else {
				Session::flash('del-warning', 'No selected records found! Nothing to delete.');
				return redirect()->back();
			}
		} else {

			$put_user_rules = [
				'put_first_name' => 'required',
				'put_last_name' => 'required',
				'put_email_address' => 'required',
				'put_company_id' => 'required'];
			$put_user_msg = [
				'put_first_name.required' => 'First name is a required field.',
				'put_last_name.required' => 'Last name is a required field.',
				'put_email_address.required' => 'E-mail address is a required field.',
				'put_company_id.required' => 'Company name is a required field.'];

			$validator = Validator::make($request->all(), $put_user_rules, $put_user_msg);

			if ($validator->fails()) {
				Session::flash('put-failed', 'Failed to update user!');
				return redirect()->back()->withErrors($validator)->withInput();
			} else {

				User::where('user_id', $request->put_user_id)->update([
					'first_name' => $request->put_first_name
					, 'last_name' => $request->put_last_name
					, 'username' => $request->put_email_address
					, 'email_address' => $request->put_email_address
					, 'user_type_id' => $request->put_user_type_id
					, 'updated_by' => $this->currentUser->user_id,
				]);

				// clear the old default company
				tbl_user_company_model::where('user_id', $request->put_user_id)->update([
					'default_flag' => ''
					, 'updated_by' => $this->currentUser->user_id,
				]);

				// set the new default company
				tbl_user_company_model::where('user_id', $request->put_user_id)->
					where('company_id', $request->put_company_id)->update([
					'default_flag' => 'Y'
					, 'updated_by' => $this->currentUser->user_id,
				]);
				return redirect()->back();
			}
		}
	}

	public function getResendverification($email_address) {
		$user = User::where('email_address', $email_address)->first();

		// check email verfication
		Mail::send('auth/verifyemail', $user->getAttributes(), function ($message) use ($email_address) {
			$message
				->to($email_address)
				->subject('Activate your NuvemHR account!');
		});

		Session::flash('add-success', 'The e-mail verification was send to ' . $user->email_address . '!');
		return redirect()->back();
	}

	public function getChangepassword() {
		return view('auth.changepassword');
	}

	public function postChangepassword(Request $request) {
		$change_password_rules = [
			'old_password' => 'required'
			, 'new_password' => 'required'
			, 'confirm_new_password' => 'required',
		];
		$change_password_msg = [
			'old_password.required' => 'Old password is a required field.'
			, 'new_password.required' => 'New password is a required field.'
			, 'confirm_new_password.required' => 'New password confirmation is a required field.',
		];

		$validator = Validator::make($request->all(), $change_password_rules, $change_password_msg);
		if ($validator->passes()) {
			if ($request->old_password == $this->currentUser->pwd) {
				if ($request->new_password == $request->confirm_new_password) {
					User::where('user_id', $this->currentUser->user_id)->update([
						'pwd' => $request->new_password,
						'updated_by' => $this->currentUser->user_id]);
					Session::flash('change-success', 'Password has been updated successfully.');
				} else {
					Session::flash('change-failed', 'New password does not match.');
				}
			} else {
				Session::flash('change-failed', 'Wrong old password entered.');
			}
		} else {
			Session::flash('change-failed', 'Failed to update password.');
		}
		return redirect('auth/changepassword');
	}

	public function rand_string() {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < 8; $i++) {
			$str .= $chars[rand(0, strlen($chars) - 1)];
		}
		return $str;
	}
}
