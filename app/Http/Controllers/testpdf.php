<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use PDF;
use App\user;
use App\Http\Requests;
use App\tbl_pagibig_model;

class testpdf extends Controller
{
    public function index()
    {
		// Method 1
		// $name = 'Bry';
		// $pdf = App::make('dompdf.wrapper');
		// $pdf->loadHTML('<h1>Hello '.$name.'</h1>');
		// return $pdf->stream();

		// Method 2
    	$user = user::find(1341);
	  	$pdf = PDF::loadView('auth.testpdf', $user->getAttributes());
		return $pdf->stream();
    }

    public function get_pagibig(){
 		$pagibig = tbl_pagibig_model::all();
 		dump($pagibig);
    }
}
