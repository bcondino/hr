<?php

namespace App\Http\Controllers;

use App\tbl_company_model;
use App\tbl_user_company_model;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {
	use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

	protected $currentUser;
	protected $currentCompany;

	public function __construct() {
		if (Auth::check()) {
			$this->currentUser = Auth::user();
			$this->currentCompany = tbl_company_model::
				where('company_id'
				, \App\tbl_user_company_model::
					where('user_id', $this->currentUser->user_id)
					->where('default_flag', 'Y')
					->first()
					->company_id)
					->first();
			view()->share('currentUser', $this->currentUser);
			view()->share('currentCompany', $this->currentCompany);
		}
	}
}
