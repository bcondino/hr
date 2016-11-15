<?php

/*@author Carlo Mendoza*/

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\tbl_user_model;
use App\tbl_report_model;
use DB;



class ReportsController extends Controller
{
	public function ProcessForm() {

		$selectedform = tbl_report_model::find(Input::get("cboForms"))->report_name;
		$id = Input::get("p0");

		if ($selectedform == "BIR FORM 1601 C") {
			$rform_ins = new PDFReportsController;
			$rform_obj = $rform_ins -> getRformc($id);
			$this -> $rform_obj;

		} else if ($selectedform == "BIR FORM 1601 E") {
			$rform_ins = new PDFReportsController;
			$rform_obj = $rform_ins -> getRforme($id);
			$this -> $rform_obj;

		} else if ($selectedform == "BIR FORM 1601 F") {
			$rform_ins = new PDFReportsController;
			$rform_obj = $rform_ins -> getRformf($id);
			$this -> $rform_obj;

		} else if ($selectedform == "sss") {
										//NEED PARAMETER?
			$rform_ins = new ExcelReportsController;
			$rform_obj = $rform_ins -> getSss($id);
			$this -> $rform_obj;

		} else if ($selectedform == "HDMF Excel") {
			$rform_ins = new ExcelReportsController;
										//NEED PARAMETER?
			$rform_obj = $rform_ins -> getHdmf($id);
			
													//NEED PARAMETER?
		} else if ($selectedform == "PAYROLL REGISTER EXCEL") {
			$rform_ins = new ExcelReportsController;
			$rform_obj = $rform_ins -> getPayroll($id);
			// $this -> $rform_obj;

		} else if ($selectedform == "CBCACAT Excel") {
			$rform_ins = new ExcelReportsController;
			$rform_obj = $rform_ins -> getCbcacat($id);
			$this -> $rform_obj;

		} else if ($selectedform == "PHILHEALTH RF1 EXCEL") {

			$rform_ins = new ExcelReportsController;
			$rform_obj = $rform_ins -> getPhform($id);
			$this -> $rform_obj;
		}

		return redirect()->back();
	}

	/*public function getUi() {
		return view('ui');
	}*/
}
