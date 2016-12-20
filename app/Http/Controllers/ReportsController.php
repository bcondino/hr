<?php

/*@author
 *
 Carlo Mendoza
 *
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\tbl_report_model;
use DB;

class ReportsController extends Controller
{
	public function ProcessForm() {

		$selectedform = tbl_report_model::find(Input::get("cboForms"))->report_name;
		$id = Input::get("p0");
		$rform_pdf = new PDFReportsController;
		$rform_exc = new ExcelReportsController;	

		switch ($selectedform) {
			case "BIR FORM 1601 C":
				$rform_pdf -> getRformc($id);
				break;
			case "BIR FORM 1601 E":
				$rform_pdf -> getRforme($id);
				break;
			case "BIR FORM 1601 F":
				$rform_pdf -> getRformf($id);
				break;
			case "HDMF Excel":
				$rform_exc -> getHdmf($id);
				break;
			case "PAYROLL REGISTER EXCEL":
				$rform_exc -> getPayroll($id);
				break;
			case "CBCACAT Excel":
				$rform_exc -> getCbcacat($id);
				break;
			case "PHILHEALTH RF1 EXCEL":
				$rform_exc -> getPhform($id);
				break;
		}

		return redirect() -> back();

	}
}
