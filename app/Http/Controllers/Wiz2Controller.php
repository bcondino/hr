<?php

namespace App\Http\Controllers;

use App\Http\Classes\AutoSeed; //20161007 updated by Melvin Militante
use App\Input;
use App\tbl_classification_model;
use App\tbl_company_model;
use App\tbl_user_company_model;
use Auth;
use Illuminate\Http\Request;
use Session;
use Validator;

class Wiz2Controller extends Controller {
	public function getIndex(Request $request) {
		$step_num = '0';
		// get user id
		$user_id = Auth::User()->user_id;

		// get if company is existing already
		$company_rec = tbl_company_model::
			where('company_id',
			tbl_user_company_model::
				where('user_id', $user_id)
				->first()
				->company_id)
				->first();

		$company_id = $company_rec == null ? null : $company_rec->company_id;

		//to control pages that $request->step can handle
		if ($request->has('step')) {
			if ($request->get('step') > 0 && $request->get('step') <= 8) {
				$step_num = $request->get('step');
			} else {
				$step_num = '0';
			}
		}

		$step = 'wiz2.setup' . $step_num;

		$data = [
			'step' => $step_num
			, 'user_id' => $user_id
			, 'comp' => $company_rec == null ? null : $company_rec->company_id,
		];
		//End of initialization

		//page determination
		switch ($step_num) {
		case '1':{
				$data['tg'] = 'wiz2.details';
				$data['tg_name'] = 'Company Details';

				$company_name = $company_id == null ? NULL : \App\tbl_company_model::find($company_id)->company_name;

				$company = [
					'id' => $company_id
					, 'name' => $company_name
					, 'address' => $company_id == 0 ? NULL : \App\tbl_company_model::find($company_id)->address
					, 'city' => $company_id == 0 ? NULL : \App\tbl_company_model::find($company_id)->city
					, 'region' => $company_id == 0 ? NULL : \App\tbl_company_model::find($company_id)->region
					, 'zip_code' => $company_id == 0 ? NULL : \App\tbl_company_model::find($company_id)->zip
					, 'contact_num' => $company_id == 0 ? NULL : \App\tbl_company_model::find($company_id)->contact_no
					, 'bus_reg_num' => $company_id == 0 ? NULL : \App\tbl_company_model::find($company_id)->bir_reg_no
					, 'tin_num' => $company_id == 0 ? NULL : \App\tbl_company_model::find($company_id)->tin_no
					, 'sss_num' => $company_id == 0 ? NULL : \App\tbl_company_model::find($company_id)->sss_no
					, 'hdmf_num' => $company_id == 0 ? NULL : \App\tbl_company_model::find($company_id)->hdmf_no
					, 'phil_health_num' => $company_id == 0 ? NULL : \App\tbl_company_model::find($company_id)->philhealth_no
					, 'bir_rdo_num' => $company_id == 0 ? NULL : \App\tbl_company_model::find($company_id)->bir_rdo_no,
				];
				//dd($company);
				$data['company'] = $company;
				break;
			}

		case '2':{
				// return view('wiz2/treeview');
				$data['tg'] = 'wiz2.treeview';
				$data['tg_name'] = 'Business Structure';
				break;
			}

		case '3':{
				$data['tg'] = 'wiz2.location';
				$data['tg_name'] = 'Location';

				$location = null;
				if ($company_id) {
					$loc_rec = \App\tbl_unit_location_model::where('company_id', $company_id)->where('active_flag', 'Y')->orderby('location_code')->get();
					if ($loc_rec->count() > 0) {
						foreach ($loc_rec as $loc) {
							$location[] = [
								'id' => $loc->location_id
								, 'code' => $loc->location_code
								, 'name' => $loc->location_name
								, 'address' => $loc->address1
								, 'city' => $loc->city,
							];
						}
					}

				} else {
					return redirect('wiz2?step=1');
				}

				$data['location'] = $location;
				break;
			}

		case '4':{
				$data['tg'] = 'wiz2.emptype';
				$data['tg_name'] = 'Employee Type';

				$employment = null;
				if ($company_id) {
					$empt_rec = \App\tbl_employee_type_model::where('company_id', $company_id)
						->where('active_flag', 'Y')
						->orderBy('emp_type_name')
						->get();

					if ($empt_rec->count() > 0) {

						foreach ($empt_rec as $empt) {
							$employment[] = [
								'type_id' => $empt->emp_type_id
								, 'type_name' => $empt->emp_type_name
								, 'min_hrs' => $empt->min_hrs
								, 'max_hrs' => $empt->max_hrs,
							];
						}
					}
				} else {
					return redirect('wiz2?step=1');
				}

				$data['employment'] = $employment;

				break;
			}

		case '5':{
				$data['tg'] = 'wiz2.sal_grade';
				$data['tg_name'] = 'Salary Grade';

				$salary_grade = null;
				$grade_rec = \App\tbl_salary_grade_model::where('company_id', '=', $company_id)
					->where('active_flag', 'Y')
					->orderBy('grade_name')
					->get();

				//dd($grade_rec);
				if ($company_id) {
					if ($grade_rec->count() > 0) {

						foreach ($grade_rec as $grade) {

							$salary_grade[] = [
								'grade_id' => $grade->grade_id
								, 'grade_name' => $grade->grade_name
								, 'minimum_salary' => $grade->minimum_salary
								, 'maximum_salary' => $grade->maximum_salary,
							];
						}
					}

				} else {
					return redirect('wiz2?step=1');
				}

				$data['salary_grade'] = $salary_grade;

				break;
			}

		case '6':{
				$data['tg'] = 'wiz2.classification';
				$data['tg_name'] = 'Classification';

				$classification = \App\tbl_classification_model::where('company_id', $company_id)
					->where('active_flag', 'Y')
					->orderBy('class_name')
					->get();

				$data['classification'] = $classification;

				break;
			}
		case '7':{
				$data['tg'] = 'wiz2.position';
				$data['tg_name'] = 'Position';

				$pos = null;
				if ($company_id) {
					$position_rec = \App\tbl_position_model::where('company_id', '=', $company_id)
						->where('active_flag', 'Y')
						->get();

					if ($position_rec->count() > 0) {
						foreach ($position_rec as $post) {
							$grade_name = \App\tbl_salary_grade_model::where('grade_id', $post->grade_id)->first()->grade_name;
							$class_name = \App\tbl_classification_model::where('class_id', $post->class_id)->first()->class_name;
							$business_unit_name = \App\tbl_business_unit_model::where('business_unit_id', $post->business_unit_id)->first()->business_unit_name;
							$pos[] = [
								'position_id' => $post->position_id
								, 'position_code' => $post->position_code
								, 'description' => $post->description
								, 'business_unit_name' => $business_unit_name
								, 'class_name' => $class_name
								, 'grade_name' => $grade_name,
							];
						}
					}
				} else {
					return redirect('wiz2?step=1');
				}
				$data['pos'] = $pos;
				break;
			}

		case '8':{
				$data['tg'] = 'wiz2.done';
				$data['tg_name'] = 'Confirmation';
				break;
			}

		default:{
				$data['tg'] = 'wiz2.welcome';
				$data['tg_name'] = 'Welcome';
			}
		}

		return view('wiz2.index', $data);
	}

	public function postCompany(Request $request) {
		//dd($request);
		$user_id = Auth::User()->user_id;
		$comp_rules = [
			'company_name' => 'required|max:250'
			, 'zip_code' => 'numeric'
			, 'bus_reg_num' => 'min:1'
			, 'tin_num' => 'min:1'
			, 'sss_num' => 'min:1'
			, 'hdmf_num' => 'min:1'
			, 'phil_health_num' => 'min:1'
			, 'bir_rdo_num' => 'min:1',
		];

		$validator = Validator::make($request->all(), $comp_rules);

		if ($validator->fails()) {
			return redirect('wiz2?step=1')
				->withErrors($validator)
				->withInput();
		} else {
			$rec = new \App\tbl_company_model();
			$rec->company_name = $request->company_name;
			$rec->address = $request->address;
			$rec->city = $request->city;
			$rec->region = $request->zip;
			$rec->zip = $request->zip;
			$rec->contact_no = $request->contact_no;
			$rec->bir_reg_no = $request->bir_reg_no;
			$rec->tin_no = $request->tin_no;
			$rec->sss_no = $request->sss_no;
			$rec->hdmf_no = $request->hdmf_no;
			$rec->philhealth_no = $request->philhealth_no;
			$rec->bir_rdo_no = $request->bir_rdo_no;
			$rec->created_by = $user_id;
			$rec->active_flag = 'Y';
			if ($rec->save()) {
				$userComp = new \App\tbl_user_company_model();
				$userComp->company_id = $rec->company_id;
				$userComp->user_id = $user_id;
				$userComp->default_flag = 'Y';
				$userComp->created_by = $user_id;
				if ($userComp->save()) {
					//dd($request->company_name);
					Session::flash('add_succ', 'A record has been added successfully.');
				}

				/* 20161007 updated by Melvin Militante */
				$autoSeed = new AutoSeed();
				$autoSeed->company_autoseed($rec->company_id);
				/* 20161007 end of update */

				return redirect('wiz2?step=2');
			} else {
				Session::flash('add_err', 'Failed to add the record.');
				return redirect()->back();
			}
		}
	}

	public function putCompany(Request $request) {
		//BEGIN putCompany
		// dd($request->all());
		/*************************************************************************************************************************
	            //BE ADVISED!
	            //Auth User Id is required here. Auth Controller must be configured or else accountability for each user will be nullified.
*/

		$user_id = Auth::User()->user_id; //Auth::User()->user_id;
		$comp_rules = [
			'company_name' => 'required|max:250'
			, 'zip_code' => 'numeric'
			, 'bus_reg_num' => 'min:1'
			, 'tin_num' => 'min:1'
			, 'sss_num' => 'min:1'
			, 'hdmf_num' => 'min:1'
			, 'phil_health_num' => 'min:1'
			, 'bir_rdo_num' => 'min:1',
		];

		if ($request->comp == null) {
			$validator = Validator::make($request->all(), $comp_rules);

			if ($validator->fails()) {
				$header_message = "Please fill with valid information the fields below.";
				return redirect('pwiz?page=2')
					->withErrors($validator)
					->with('display', 'Errors detected. Fill in the fields below with valid information.')
					->withInput()
				;
			} else {
				$rec = new \App\tbl_company_model();

				$rec->company_name = trim($request->input('company_name'), "\x00..\x1F");
				$rec->address = $request->address;
				$rec->city = $request->city;
				$rec->region = $request->region;
				$rec->zip = $request->zip_code;
				$rec->contact_no = $request->contact_num;
				$rec->bir_reg_no = $request->bus_reg_num;
				$rec->tin_no = $request->tin_num;
				$rec->sss_no = $request->sss_num;
				$rec->hdmf_no = $request->hdmf_num;
				$rec->philhealth_no = $request->phil_health_num;
				$rec->bir_rdo_no = $request->bir_rdo_num;

				$rec->created_by = $user_id;
				$rec->user_id = $user_id;
				$rec->created_by = $user_id;
				$rec->active_flag = 'Y';

				$rec->save();

				/* 20161007 updated by Melvin Militante */
				$autoSeed = new AutoSeed();
				$autoSeed->company_autoseed($rec->company_id);
				/* 20161007 end of update */

				return redirect('wiz2?step=2');
			}

		} else {

			$validator = Validator::make($request->all(), $comp_rules);

			if ($validator->fails()) {
				// doing the validation, passing post data, rules and the messages
				return redirect()->back()
					->withErrors($validator)
					->with('display', 'Errors detected. Fill in the fields below with valid information.')
				;

			} else {
				$this->updateCompany($request->comp, $request, $user_id);
				return redirect('wiz2?step=2')
					->with('display', 'Company Details have been updated successfully.')
					->withInput()
				;
			}

		}

	} //end putCompany

	public function updateCompany($company_id, $data, $user_id) {

		$cols = [
			'company_name' => $data->company_name
			, 'address' => $data->address
			, 'region' => $data->region
			, 'city' => $data->city
			, 'zip' => $data->zip
			, 'bir_reg_no' => $data->bir_reg_no
			, 'tin_no' => $data->tin_no
			, 'sss_no' => $data->sss_no
			, 'hdmf_no' => $data->hdmf_no
			, 'philhealth_no' => $data->philhealth_no
			, 'bir_rdo_no' => $data->bir_rdo_no
			, 'contact_no' => $data->contact_no
			, 'updated_by' => $user_id,
		];
		//dd($cols);
		$company = \App\tbl_company_model::find($company_id);
		$company->update($cols);

	} // END updateCompany

	// set all validation rules

	public function postLocation(Request $request, $company_id) {
		//BEGIN putLocation

		$user_id = Auth::User()->user_id;
		$add_location_rules = [
			'location_code' => 'required'];
		$add_location_msg = [
			'location_code.required' => 'Location code is a required field.'];
		$validator = Validator::make($request->all(), $add_location_rules, $add_location_msg);

		if ($validator->fails()) {
			$request->session()->flash('add-failed', 'Failed to add new location details!');
			return redirect('wiz2?step=3')->withErrors($validator)->withInput();
		} else {
			$rec = new \App\tbl_unit_location_model();
			$rec->location_name = $request->location_name;
			$rec->location_code = $request->location_code;
			$rec->address1 = $request->address;
			$rec->city = $request->city;
			$rec->company_id = $company_id;
			$rec->created_by = $user_id;
			$rec->active_flag = 'Y';
			if ($rec->save()) {
				$request->session()->flash('add-success', 'New location has been added successfully!');
				return redirect()->back();
			}

		}

	} // END postLocation

	public function putLocation(Request $request) {
		//UPDATE status
		$user_id = Auth::User()->user_id;
		$put_location_rules = [
			'edt_location_code' => 'required'];
		$put_location_msg = [
			'edt_location_code.required' => 'Location code is a required field.'];
		$validator = Validator::make($request->all(), $put_location_rules, $put_location_msg);

		if ($request->edit_flag) {
			if ($validator->fails()) {
				Session::flash('put-failed', 'Failed to update location details!');
				return redirect()->back()->withErrors($validator)->withInput();
			} else {
				$cols = [
					'location_name' => $request->edt_location_name
					, 'location_code' => $request->edt_location_code
					, 'address1' => $request->edt_address
					, 'city' => $request->edt_city
					, 'updated_by' => $user_id,
				];

				$loc = \App\tbl_unit_location_model::find($request->edt_location_id);
				if ($loc->update($cols)) {
					Session::flash('put-success', 'Location detail has been updated sucessfully!');
				}
			}
		} else {
			if (count($request->location) > 0) {
				foreach ($request->location as $loc) {
					$loc_rec = \App\tbl_unit_location_model::find($loc)
						->update([
							'active_flag' => 'N'
							, 'updated_by' => $user_id]);
				}
				Session::flash('del-success', 'Records selected have been deleted successfully.');
			} else {
				Session::flash('del-warning', 'No selected records found! Nothing to delete.');
			}
		}
		return redirect()->back();
	} //end putLocation

	public function postEmployment(Request $request, $company_id) {

		$user_id = Auth::User()->user_id;

		$add_emptype_rules = [
			'type_name' => 'required'
			, 'min_hrs' => 'required'
			, 'max_hrs' => 'required',
		];

		$add_emptype_msg = [
			'type_name.required' => 'Employment Type is a required field.'
			, 'min_hrs.required' => 'Minimum Hours is a required field.'
			, 'max_hrs.required' => 'Maximum Hours is a required field.',
		];
		$validator = Validator::make($request->all(), $add_emptype_rules, $add_emptype_msg);

		if ($validator->fails()) {
			$request->session()->flash('add-failed', 'Failed to add new employment type!');
			return redirect()->back()->withErrors($validator)->withInput();
		} else {
			$rec = new \App\tbl_employee_type_model();
			$rec->emp_type_name = $request->type_name;
			$rec->min_hrs = $request->min_hrs;
			$rec->max_hrs = $request->max_hrs;
			$rec->company_id = $company_id;
			$rec->created_by = $user_id;
			$rec->active_flag = 'Y';
			if ($rec->save()) {
				$request->session()->flash('add-success', 'New employment type has been added successfully!');
				return redirect()->back();
			} else {
				$request->session()->flash('add-error', 'Failed to add the employment type!');
				return redirect()->back();
			}
		}

	} //end postEmploymentem

	public function putEmployment(Request $request) {
		//UPDATE status
		$user_id = Auth::User()->user_id;

		$put_emptype_rules = [
			'edt_type_name' => 'required'
			, 'edt_min_hrs' => 'required'
			, 'edt_max_hrs' => 'required',
		];

		$put_emptype_msg = [
			'edt_type_name.required' => 'Employment Type is a required field.'
			, 'edt_min_hrs.required' => 'Minimum Hours is a required field.'
			, 'edt_max_hrs.required' => 'Maximum Hours is a required field.',
		];

		$validator = Validator::make($request->all(), $put_emptype_rules, $put_emptype_msg);

		if ($request->edit_flag) {
			if ($validator->fails()) {
				Session::flash('put-failed', 'Failed to update location details!');
				return redirect()->back()->withErrors($validator)->withInput();
			} else {
				$cols = [
					'emp_type_name' => $request->edt_type_name
					, 'min_hrs' => $request->edt_min_hrs
					, 'max_hrs' => $request->edt_max_hrs
					, 'updated_by' => $user_id,
				];

				$employment = \App\tbl_employee_type_model::find($request->edt_emptype_id);

				if ($employment->update($cols)) {
					Session::flash('put-success', 'Employment Type has been updated sucessfully!');
					return redirect()->back();
				}
			}
		} // end if

		else {
			if (count($request->emptype) > 0) {
				foreach ($request->emptype as $type) {
					$emptype_rec = \App\tbl_employee_type_model::find($type)->update(['active_flag' => 'N', 'updated_by' => $user_id]);
				}
				Session::flash('del-success', 'Records selected have been deleted successfully.');
			} else {
				Session::flash('del-warning', 'No selected records found! Nothing to delete.');
			}
		} // end else
		return redirect()->back();

	} // end putEmployment

	public function postGrade(Request $request, $company_id) {
		//BEGIN post

		$user_id = Auth::User()->user_id;

		$add_grade_rules = [
			'grade_name' => 'required'
			, 'min_sal' => 'required'
			, 'max_sal' => 'required',
		];

		$add_grade_msg = [
			'grade_name.required' => 'Salary Grade is a required field.'
			, 'min_sal.required' => 'Minimum Salary is a required field.'
			, 'max_sal.required' => 'Maximum Salary is a required field.',
		];

		$validator = Validator::make($request->all(), $add_grade_rules, $add_grade_msg);

		if ($validator->fails()) {
			$request->session()->flash('add-failed', 'Failed to add new salary grade!');
			return redirect()->back()->withErrors($validator)->withInput();
		} else {

			$rec = new \App\tbl_salary_grade_model();
			$rec->grade_name = $request->grade_name;
			$rec->minimum_salary = $request->min_sal;
			$rec->maximum_salary = $request->max_sal;
			$rec->company_id = $company_id;
			$rec->created_by = $user_id;
			$rec->active_flag = 'Y';

			if ($rec->save()) {
				$request->session()->flash('add-success', 'New salary grade has been added successfully!');
				return redirect()->back();
			}
		}

		return redirect()->back();
	} //end postEmployment

	public function putGrade(Request $request) {
		//UPDATE status
		$user_id = Auth::User()->user_id;

		$put_grade_rules = [
			'edt_grade_name' => 'required'
			, 'edt_min_sal' => 'required'
			, 'edt_max_sal' => 'required',
		];

		$put_grade_msg = [
			'edt_grade_name.required' => 'Salary Grade is a required field.'
			, 'edt_min_sal.required' => 'Minimum Salary is a required field.'
			, 'edt_max_sal.required' => 'Maximum Salary is a required field.',
		];

		$validator = Validator::make($request->all(), $put_grade_rules, $put_grade_msg);

		if ($request->edit_flag) {

			if ($validator->fails()) {
				Session::flash('put-failed', 'Failed to update salary grade!');
				return redirect()->back()->withErrors($validator)->withInput();
			} else {

				$cols = [
					'grade_name' => $request->edt_grade_name
					, 'minimum_salary' => $request->edt_min_sal
					, 'maximum_salary' => $request->edt_max_sal
					, 'updated_by' => $user_id,
				];

				$grade = \App\tbl_salary_grade_model::find($request->edt_grade_id);
				if ($grade->update($cols)) {
					Session::flash('put-success', 'Salary grade has been updated sucessfully!');
					return redirect()->back();
				}
			}
		} // end if

		else {
			if (count($request->grade) > 0) {
				foreach ($request->grade as $grade) {
					\App\tbl_salary_grade_model::find($grade)->update(['active_flag' => 'N', 'updated_by' => $user_id]);
				}
				Session::flash('del-success', 'Records selected have been deleted successfully.');
			} else {
				Session::flash('del-warning', 'No selected records found! Nothing to delete.');
			}
		}
		return redirect()->back();

	} // end putGrade

	public function postClassification(Request $request, $company_id) {
		$user_id = Auth::User()->user_id;

		$add_class_rules = [
			'class_name' => 'required'];
		$add_class_msg = [
			'class_name.required' => 'Classification name is a required field.'];

		$validator = Validator::make($request->all(), $add_class_rules, $add_class_msg);

		if ($validator->fails()) {
			Session::flash('add-failed', 'Failed to add new classification name!');
			return redirect()->back()->withErrors($validator)->withInput();
		} else {
			\App\tbl_classification_model::create([
				'class_name' => $request->class_name
				, 'active_flag' => 'Y'
				, 'company_id' => $company_id
				, 'created_by' => $user_id
				, 'updated_by' => $user_id,
			]);
			Session::flash('add-success', 'New classification has been added successfully!');
		}
		return redirect()->back();
	}

	public function putClassification(Request $request) {
		$user_id = Auth::User()->user_id;

		if ($request->isDelete) {
			if (count($request->classification) > 0) {
				foreach ($request->classification as $class) {
					\App\tbl_classification_model::find($class)->update([
						'active_flag' => 'Y'
						, 'updated_by' => $user_id,
					]);
				}
				Session::flash('del-success', 'Records selected have been deleted successfully.');
			} else {
				Session::flash('del-warning', 'No selected records found! Nothing to delete.');
			}
		} else {
			$put_emptype_rules = [
				'put_class_name' => 'required'];
			$put_emptype_msg = [
				'put_class_name.required' => 'Classification is a required field.'];
			$validator = Validator::make($request->all(), $put_emptype_rules, $put_emptype_msg);
			if ($validator->fails()) {
				Session::flash('put-failed', 'Failed to update classification successfully!');
				return redirect()->back()->withErrors($validator)->withInput();
			} else {
				\App\tbl_classification_model::find($request->put_class_id)->update([
					'class_name' => $request->put_class_name
					, 'updated_by' => $user_id,
				]);
				Session::flash('put-success', 'Classification has been updated successfully.');
			}
		}
		return redirect()->back();
	}

	// public function postGrade(Request $request, $company_id){
	// //BEGIN post

	//     $user_id = Auth::User()->user_id;

	//     $add_grade_rules = [
	//     'grade_name'      => 'required'
	//     ,'min_sal'       => 'required'
	//     ,'max_sal'       => 'required'
	//     ];

	//     $add_grade_msg = [
	//     'grade_name.required' => 'Salary Grade is a required field.'
	//     ,'min_sal.required' => 'Minimum Salary is a required field.'
	//     ,'max_sal.required' => 'Maximum Salary is a required field.'
	//     ];

	//     $validator = Validator::make($request->all(), $add_grade_rules, $add_grade_msg);

	//     if($validator->fails()){
	//         $request->session()->flash('add-failed', 'Failed to add new salary grade!');
	//         return redirect()->back()->withErrors($validator)->withInput();
	//     }

	//     else{

	//         $rec = new \App\tbl_salary_grade_model();
	//         $rec->grade_name = $request->grade_name;
	//         $rec->minimum_salary  = $request->min_sal;
	//         $rec->maximum_salary  = $request->max_sal;
	//         $rec->company_id    = $company_id;
	//         $rec->created_by    = $user_id;
	//         $rec->active_flag   = 'Y';

	//         if($rec->save()){
	//             $request->session()->flash('add-success', 'New salary grade has been added successfully!');
	//             return redirect()->back();
	//         }
	//     }

	//     return redirect()->back();
	// }//end postEmployment

	// public function putGrade(Request $request){
	//     //UPDATE status
	//     $user_id = Auth::User()->user_id;

	//     $put_grade_rules = [
	//     'edt_grade_name'      => 'required'
	//     ,'edt_min_sal'       => 'required'
	//     ,'edt_max_sal'       => 'required'
	//     ];

	//     $put_grade_msg = [
	//     'edt_grade_name.required' => 'Salary Grade is a required field.'
	//     ,'edt_min_sal.required' => 'Minimum Salary is a required field.'
	//     ,'edt_max_sal.required' => 'Maximum Salary is a required field.'
	//     ];

	//     $validator = Validator::make($request->all(), $put_grade_rules, $put_grade_msg);

	//     if ($request->edit_flag) {

	//         if ($validator->fails()) {
	//             Session::flash('put-failed', 'Failed to update salary grade!');
	//             return redirect()->back()->withErrors($validator)->withInput();
	//         }

	//         else{

	//             $cols =[
	//                 'grade_name' => $request->edt_grade_name
	//             ,   'minimum_salary' => $request->edt_min_sal
	//             ,   'maximum_salary'      => $request->edt_max_sal
	//             ,   'updated_by'   => $user_id
	//             ];

	//             $grade = \App\tbl_salary_grade_model::find($request->edt_grade_id);
	//             if($grade->update($cols)){
	//                 Session::flash('put-success', 'Salary grade has been updated sucessfully!');
	//                 return redirect()->back();
	//             }
	//         }
	//     } // end if

	//     else{
	//         if(count($request->grade) > 0)
	//         {
	//             foreach ($request->grade as $grade) {
	//                 \App\tbl_salary_grade_model::find($grade)->update(['active_flag' => 'N', 'updated_by' => $user_id]);
	//             }
	//             Session::flash('del-success', 'Records selected have been deleted successfully.');
	//         }
	//         else
	//         {
	//             Session::flash('del-warning', 'No selected records found! Nothing to delete.');
	//         }
	//     }
	//     return redirect()->back();

	// }// end putGrade

	// public function postClassification(Request $request, $company_id)
	// {
	//     $user_id = Auth::User()->user_id;

	//     $add_class_rules = [
	//         'class_name' => 'required' ];
	//     $add_class_msg = [
	//         'class_name.required' => 'Classification name is a required field.' ];

	//     $validator = Validator::make($request->all(), $add_class_rules, $add_class_msg);

	//     if($validator->fails())
	//     {
	//         Session::flash('add-failed', 'Failed to add new classification name!');
	//         return redirect()->back()->withErrors($validator)->withInput();
	//     }
	//     else{
	//         \App\tbl_classification_model::create([
	//                  'class_name'  => $request->class_name
	//                 ,'active_flag' => 'Y'
	//                 ,'company_id'  => $company_id
	//                 ,'created_by'  => $user_id
	//                 ,'updated_by'  => $user_id
	//             ]);
	//         Session::flash('add-success', 'New classification has been added successfully!');
	//     }
	//     return redirect()->back();
	// }

	// public function postPosition(Request $request, $company_id){

	//     $user_id = Auth::User()->user_id;

	//     $add_post_rules = [
	//         'position_code' => 'required'
	//         ,'business_unit' => 'required'
	//         , 'salary_grade' => 'required'
	//         , 'classification' => 'required'
	//     ];
	//     $add_post_msg = [
	//         'position_code.required' => 'Position code is a required field.'
	//         ,'business_unit.required' => 'Business unit is a required field.'
	//         ,'salary_grade.required' => 'Salary grade is a required field.'
	//         ,'classification.required' => 'Classification is a required field.'
	//     ];

	//     $validator = Validator::make($request->all(), $add_post_rules, $add_post_msg);

	//     if($validator->fails()){
	//         $request->session()->flash('add-failed', 'Failed to add new position!');
	//         return redirect()->back()->withErrors($validator)->withInput();
	//     }
	//     else{
	//         $rec = new \App\tbl_position_model();
	//         $rec->position_code     = $request->position_code;
	//         $rec->description       = $request->position_name;
	//         $rec->company_id        = $company_id;
	//         $rec->business_unit_id  = $request->business_unit;
	//         $rec->grade_id          = $request->salary_grade;
	//         $rec->class_id          = $request->classification;
	//         $rec->created_by        = $user_id;
	//         $rec->active_flag       = 'Y';
	//         if($rec->save()){
	//             $request->session()->flash('add-success', 'New position has been added successfully!');
	//             return redirect()->back();
	//         }
	//     }

	//     return redirect()->back();
	// }//end postPosition

	// public function putPosition(Request $request){
	//     //UPDATE status
	//     $user_id = Auth::User()->user_id;
	//     $put_post_rules = [
	//          'edt_position_code' => 'required'
	//         ,'edt_business_unit' => 'required'
	//         ,'edt_salary_grade' => 'required'
	//         ,'edt_classification' => 'required'
	//     ];
	//     $put_post_msg = [
	//         'edt_position_code.required' => 'Position code is a required field.'
	//         ,'edt_business_unit.required' => 'Business unit is a required field.'
	//         ,'edt_salary_grade.required' => 'Salary grade is a required field.'
	//         ,'edt_classification.required' => 'Classification is a required field.'
	//     ];

	//     $validator = Validator::make($request->all(), $put_post_rules, $put_post_msg);

	//     if ($request->edit_flag) {

	//        if ($validator->fails()) {
	//             Session::flash('put-failed', 'Failed to update position details!');
	//             return redirect()->back()->withErrors($validator)->withInput();
	//         }

	//        else{

	//             $grade = \App\tbl_position_model::find($request->edt_position_id);
	//             $cols =[
	//                'position_code'         => $request->edt_position_code
	//                ,   'description'       => $request->edt_position_name
	//                ,   'business_unit_id'  => $request->edt_business_unit
	//                ,   'grade_id'          => $request->edt_salary_grade
	//                ,   'class_id'          => $request->edt_classification
	//                ,   'updated_by'        => $user_id
	//                ];

	//             if($grade->update($cols)){
	//                 Session::flash('put-success', 'Position detail has been updated sucessfully!');
	//                 return redirect()->back();
	//             }
	//         }

	//     } // end if

	//     else{
	//         if(count($request->post2) > 0)
	//         {
	//             foreach ($request->post2 as $post) {
	//                 $post_rec = \App\tbl_position_model::find($post)->update(['active_flag' => 'Y', 'updated_by' => $user_id]);
	//             }
	//             Session::flash('del-success', 'Records selected have been deleted successfully.');
	//         }
	//         else
	//         {
	//             Session::flash('del-warning', 'No selected records found! Nothing to delete.');
	//         }
	//     }     // end else
	//     return redirect()->back();
	// }// end putGrade

	public function postPosition(Request $request, $company_id) {
		/* 20161007 updated by Melvin Militante
				- Uncommented the whole function postPosition
			*/
		$user_id = Auth::User()->user_id;

		$add_post_rules = [
			'position_code' => 'required'
			, 'business_unit' => 'required'
			, 'salary_grade' => 'required'
			, 'classification' => 'required',
		];
		$add_post_msg = [
			'position_code.required' => 'Position code is a required field.'
			, 'business_unit.required' => 'Business unit is a required field.'
			, 'salary_grade.required' => 'Salary grade is a required field.'
			, 'classification.required' => 'Classification is a required field.',
		];

		$validator = Validator::make($request->all(), $add_post_rules, $add_post_msg);

		if ($validator->fails()) {
			$request->session()->flash('add-failed', 'Failed to add new position!');
			return redirect()->back()->withErrors($validator)->withInput();
		} else {
			$rec = new \App\tbl_position_model();
			$rec->position_code = $request->position_code;
			$rec->description = $request->position_name;
			$rec->company_id = $company_id;
			$rec->business_unit_id = $request->business_unit;
			$rec->grade_id = $request->salary_grade;
			$rec->class_id = $request->classification;
			$rec->created_by = $user_id;
			$rec->active_flag = 'Y';
			if ($rec->save()) {
				$request->session()->flash('add-success', 'New position has been added successfully!');
				return redirect()->back();
			}
		}

		return redirect()->back();
	} //end postPosition

	public function putPosition(Request $request) {
		//UPDATE status
		$user_id = Auth::User()->user_id;
		$put_post_rules = [
			'edt_position_code' => 'required'
			, 'edt_business_unit' => 'required'
			, 'edt_salary_grade' => 'required'
			, 'edt_classification' => 'required',
		];
		$put_post_msg = [
			'edt_position_code.required' => 'Position code is a required field.'
			, 'edt_business_unit.required' => 'Business unit is a required field.'
			, 'edt_salary_grade.required' => 'Salary grade is a required field.'
			, 'edt_classification.required' => 'Classification is a required field.',
		];

		$validator = Validator::make($request->all(), $put_post_rules, $put_post_msg);

		if ($request->edit_flag) {

			if ($validator->fails()) {
				Session::flash('put-failed', 'Failed to update position details!');
				return redirect()->back()->withErrors($validator)->withInput();
			} else {

				$grade = \App\tbl_position_model::find($request->edt_position_id);
				$cols = [
					'position_code' => $request->edt_position_code
					, 'description' => $request->edt_position_name
					, 'business_unit_id' => $request->edt_business_unit
					, 'grade_id' => $request->edt_salary_grade
					, 'class_id' => $request->edt_classification
					, 'updated_by' => $user_id,
				];

				if ($grade->update($cols)) {
					Session::flash('put-success', 'Position detail has been updated sucessfully!');
					return redirect()->back();
				}
			}

		} // end if

		else {
			if (count($request->post2) > 0) {
				foreach ($request->post2 as $post) {
					$post_rec = \App\tbl_position_model::find($post)->update(['active_flag' => 'Y', 'updated_by' => $user_id]);
				}
				Session::flash('del-success', 'Records selected have been deleted successfully.');
			} else {
				Session::flash('del-warning', 'No selected records found! Nothing to delete.');
			}
		} // end else
		return redirect()->back();
	} // end putGrade

	public function cancel($company_id) {
		$user_id = Auth::User()->user_id;
		if ($company_id) {
			$cols = [
				'active_flag' => 'N',
			];
			$company = \App\tbl_company_model::find($company_id);
			$company->update($cols);
			$ucols = [
				'is_first_logged' => 'Y',
			];
			$userLogged = \App\User::where('user_id', $user_id)->first();
			$userLogged->update($ucols);
		}
		return redirect('auth/logout');
	}

	public function postCancel(Request $request) {
		/* 20161007 added by Melvin Militante
					- This function is added for handling the cancel button on welcome screen of the initial configuration
				*/
		return redirect('home');
	}

	public function deleteClassification(Request $request) {
		/* 20161007 added by Melvin Militante
					- This function is added for handling deletion on classification screen of the initial configuration
				*/
		$user_id = Auth::User()->user_id;
		if (count($request->classification) > 0) {
			foreach ($request->classification as $clsf) {
				$class_rec = \App\tbl_classification_model::find($clsf)
					->update(
						['active_flag' => 'N'
							, 'updated_by' => $user_id]);
			}

			Session::flash('del-success', 'Records selected have been deleted successfully.');

		} else {

			Session::flash('del-warning', 'No selected records found! Nothing to delete.');

		}
		return redirect()->back();
	}
}
