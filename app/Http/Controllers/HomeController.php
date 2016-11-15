<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\User;
use App\tbl_user_company_model;
use App\tbl_company_model;

class HomeController extends Controller
{

	public function getIndex()
	{
		return view('main.index');
	}
}
