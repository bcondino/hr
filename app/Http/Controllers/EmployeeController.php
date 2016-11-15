<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\tbl_dependents_model;
use App\tbl_dep_type_model;
use App\tbl_education_background_model;
use App\tbl_employee_model;
use App\tbl_employee_type_model;
use App\tbl_employment_history_model;
use App\tbl_position_model;
use App\tbl_salary_grade_model;
use App\tbl_user_company_model;
use App\tbl_payroll_group_model;
use App\tbl_movement_model;
use App\tbl_tax_code_model;
/* 20161014 update from Hector Esquillo
	-Reason: Added movement functionality for the system
*/
use App\tbl_business_unit_model;
use App\tbl_company_model;
use App\tbl_classification_model;
use DB;
/* 20161014 end of update */
use Auth;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect;
use Session;
use Validator;
use DateTime;		// 20161020 added by Melvin Militante; Reason: to tackle future date limitation of strtotime function.

class EmployeeController extends Controller
{
    // employee
    public function getEmployees()
    {
        $employees = tbl_employee_model::where('active_flag','Y')
            ->where('company_id'
                , tbl_user_company_model::
                    where('default_flag', 'Y')
                    ->where('user_id', $this->currentUser->user_id)
                    ->first()
                    ->company_id)
            ->orderBy('employee_number')
            ->get();
        return view('main/employee/employee', ['employees' => $employees]);
    }

    public function postEmployees(Request $request)
    {
        $add_employee_rules = [
            'employee_number' => 'required'
            , 'first_name' => 'required'
            , 'last_name' => 'required'];
        $add_employee_msg = [
            'employee_number.required' => 'Employee number is a required field.',
            'first_name.required'      => 'First name is a required field.',
            'last_name.required'       => 'Last name is a required field.',
			'date_hired.required'      => 'Date hired is a required field.'];		// 20161014 update from Hector Esquillo
        $validator = Validator::make($request->all(), $add_employee_rules, $add_employee_msg);
        if ($validator->fails()) {
            Session::flash('add-failed', 'Failed to add new employee!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
			/* 20161014 update from Hector Esquillo
				-Reason: Concerning addition of movement functionality
			*/
            //tbl_employee_model::create([
            //    'employee_number' => $request->employee_number,
            //    'last_name'       => $request->last_name,
            //    'first_name'      => $request->first_name,
            //    'middle_name'     => $request->middle_name,
            //    'gender'          => $request->gender,
            //    'civil_stat'      => $request->civil_stat,
            //    'e_mail'          => $request->e_mail,
            //    'mobile_no'       => $request->mobile_no,
            //    'created_by'      => $this->currentUser->user_id,
            //    'updated_by'      => $this->currentUser->user_id,
            //    'company_id'      => $this->currentCompany->company_id,
            //]);
			
			$employee_info =  tbl_employee_model::create(
				['employee_number'	=> $request->employee_number
				,'last_name'       	=> $request->last_name
				,'first_name'      	=> $request->first_name
				,'middle_name'     	=> $request->middle_name
				,'date_hired'     	=> $request->date_hired
				,'gender'         	=> $request->gender
				,'civil_stat'      	=> $request->civil_stat
				,'e_mail'          	=> $request->e_mail
				,'mobile_no'       	=> $request->mobile_no
				,'created_by'      	=> $this->currentUser->user_id
				,'updated_by'      	=> $this->currentUser->user_id
				,'company_id'      	=> $this->currentCompany->company_id,]
			);
			
			tbl_movement_model::create(
				['employee_id'				=> $employee_info->employee_id
				,'effective_date'			=>$employee_info->created_at
				,'payroll_type_id_basic'	=> '1'
				,'active_flag'    			=> 'Y'
				,'remarks'					=> 'Initial movement'
				,'created_by'     			=> $this->currentUser->user_id
				,'company_id'      			=> $this->currentCompany->company_id,]
			);
			
			/* 201610014 end of update */
				
            Session::flash('add-success', 'New employee has been added successfully!');
            return redirect()->back();
        }
    }

    public function putEmployees(Request $request)
    {
        if($request->isDelete) {
            if (count($request->employees) > 0) {
                foreach ($request->employees as $employee) {
                    tbl_employee_model::find($employee)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');            
            }
            else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }            
        }
        return redirect()->back();
    }

    public function getExportemployee()
    {
        $type = 'xls';
        $data = [
            ['Data Import Template for Employee Details'],
            ['***   Copy the headers below and fill up the available data.  ***'],
            ['employee_number', 'salutation', 'last_name', 'first_name', 'middle_name', 'date_birth', 'gender', 'civil_stat', 'nationality', 'active_flag', 'address1', 'address2', 'city', 'region', 'zip', 'e_mail', 'mobile_no', 'tel_no', 'tin_no', 'philhealth_no', 'hdmf_no', 'sss_no', 'gsis_no', 'rdo_no'],
            ['  '],
            ['***   Sample Data  ***'],
            ['2015-002', 'Mr.', 'Condino', 'Brayan', 'Cheng', '30/11/1995', 'Male', 'Single', 'Filipino', 'Y', '123 Condino Compound', 'Canumay West', 'Valenzuela City', 'NCR', '1407', 'bcondino@abcxyz.com', '09271130995', '', '', '', '', '', '', ''],
            ['2015-003', 'Mr.', 'Esquillo', 'Hector', 'Bartolome', '22/07/1968', 'Male', 'Married', 'Filipino', 'Y', '22F Chicago Tech,University Hills,', 'Brgy.80', 'Caloocan City', 'NCR', '1200', 'hesquillo@abcxyz.com', '09267221968', '', '', '', '', '', '', ''],
            ['2015-004', 'Ms.', 'Paguinto', 'Lorraine', 'Dela Minez', '01/09/1992', 'Female', 'Single', 'Filipino', 'Y', '456 LMP Villa, Sunshine Ville Subd.,', 'Brgy. Buhay', 'Quezon City', 'NCR', '1309', 'lpaguinto@abcxyz.com', '09259011992', '', '', '', '', '', '', ''],
            ['  '],
            [' *** Follow the date_birth column format.  Format Cell = text  value=dd/mm/yyyy '],
            ['*** Save your file as  xls file  ex. file_name.xls ****'],
        ];
        return Excel::create('employee_upload_template', function ($excel) use ($data) {
            $excel->sheet('mySheet', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        }
        )->download($type);

    } 

    public function postImportemployee()
    {
        $employees  = new \App\tbl_employee_model();

        // rules
        $mass_employee_rules = [
            'employee_number' => 'required'
            , 'first_name' => 'required'
            , 'last_name' => 'required'
            , 'middle_name' => 'required'];
        $mass_employee_msg = [
            'employee_number.required' => 'Employee number is a required field.',
            'first_name.required'      => 'First name is a required field.',
            'last_name.required'       => 'Last name is a required field.',
            'middle_name.required'     => 'Middle name is a required field.'];

        if (Input::hasFile('import_emp_file')) {
            $path = Input::file('import_emp_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {})->get();

            if (!empty($data) && $data->count()) {
                foreach ($data as $key => $value) {
                    //dump($key);
                    $insert[] = ['employee_number' => $value->employee_number,
                        'salutation'                   => $value->salutation,
                        'last_name'                    => $value->last_name,
                        'first_name'                   => $value->first_name,
                        'middle_name'                  => $value->middle_name,
                        'date_birth'                   => $value->date_birth,
                        'gender'                       => $value->gender,
                        'civil_stat'                   => $value->civil_stat,
                        'nationality'                  => $value->nationality,
                        'mobile_no'                    => $value->mobile_no,
                        'active_flag'                  => $value->active_flag,
                        'address1'                     => $value->address1,
                        'address2'                     => $value->address2,
                        'city'                         => $value->city,
                        'region'                       => $value->region,
                        'zip'                          => $value->zip,
                        'e_mail'                       => $value->e_mail,
                        'tel_no'                       => $value->tel_no,
                        'tin_no'                       => $value->tin_no,
                        'philhealth_no'                => $value->philhealth_no,
                        'hdmf_no'                      => $value->hdmf_no,
                        'sss_no'                       => $value->sss_no,
                        'gsis_no'                      => $value->gsis_no,
                        'rdo_no'                       => $value->rdo_no,
                        'created_by'                   => $this->currentUser->user_id,
                        'updated_by'                   => $this->currentUser->user_id,
                        'company_id'                   => $this->currentCompany->company_id,
                    ];
                }

                if (!empty($insert)) {
                    $validator = Validator::make($insert, $mass_employee_rules, $mass_employee_msg);
                    if ($validator->fails()) {
                        Session::flash('mass-failed', 'Mass upload for employee failed.');
                        return redirect()->back()->withErrors($validator);
                    }
                    $employees->insert($insert);
                    Session::flash('mass-success', 'Mass upload for employee success');
                    return redirect()->back();
                }
            }
        }
    }

    public function getBasicinformation($employee_id)
    {
        $employee = tbl_employee_model::find($employee_id);
        return view('main/employee/profile', ['employee' => $employee]);
    }

    public function getGovernmentdetails($employee_id)
    {
        $employee = tbl_employee_model::find($employee_id);
        return view('main/employee/government', ['employee' => $employee]);
    }

    public function getContactinformation($employee_id)
    {
        $employee = tbl_employee_model::find($employee_id);
        return view('main/employee/contactinformation', ['employee' => $employee]);
    }

    public function getEmploymentdetails($employee_id)
    {
        $employee = tbl_employee_model::find($employee_id);
        $emp_type  = tbl_employee_type_model::
                        where('company_id', $this->currentCompany->company_id)
                        ->where('active_flag', 'Y')
                        ->get();
        $emp_pos   = tbl_position_model::
                        where('company_id', $this->currentCompany->company_id)
                        ->where('active_flag', 'Y')
                        ->get();
        $emp_pay_group = tbl_payroll_group_model::
                        where('company_id', $this->currentCompany->company_id)
                        ->where('active_flag', 'Y')
                        ->get();
		/* 20161014 update from Hector Esquillo
			-Reason: Concerning addition of movement functionality
		*/
		$emp_movements = tbl_movement_model ::
						 where('company_id', $this->currentCompany->company_id)
                        ->where('active_flag', 'Y')
                        ->get();
		/* 20161014 end of update */
        return view('main/employee/employment'
            , ['employee' => $employee
                , 'emp_type' => $emp_type
                , 'emp_pos' => $emp_pos
				, 'emp_movements' => $emp_movements		// 20161014 update from Hector Esquillo
                , 'emp_pay_group' => $emp_pay_group]);
    }

    public function getDependent($employee_id)
    {
        $employee = tbl_employee_model::find($employee_id);
        $dependent = tbl_dependents_model::
            where('employee_id', $employee->employee_id)
            ->where('active_flag', 'Y')
            ->orderBy('first_name')
            ->get();
        return view('main/employee/dependent', ['employee' => $employee, 'dependents' => $dependent]);
    }

    public function postDependent(Request $request, $employee_id)
    {
        $add_dependents_rules = [
             'last_name' => 'required'
            ,'first_name' => 'required'
            ,'dependent_type_id' => 'required'];
        $add_dependents_msg = [
             'last_name.required' => 'Last name is a required field.'
            ,'first_name.required' => 'First name is a required field.'
            ,'dependent_type_id.required' => 'Dependent type is a required field.'];
        $validator = Validator::make($request->all(), $add_dependents_rules, $add_dependents_msg);
        if ($validator->fails()) {
            Session::flash('add-failed', 'Failed to add new dependent!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_dependents_model::create([
                'employee_id'    => $employee_id,
                'last_name'      => $request->last_name,
                'first_name'     => $request->first_name,
                'mid_name'       => $request->mid_name,
                'dependent_type' => $request->dependent_type_id,
                'gender'         => $request->gender,
                'civil_stat'     => $request->civil_stat,
                'date_birth'     => $request->date_birth,
                'address'        => $request->address,
                'occupation'     => $request->occupation,
                'is_benef'       => $request->is_benef,
                'is_tax_dep'     => $request->is_tax_dep,
                'active_flag'    => 'Y',
                'created_by'     => $this->currentUser->user_id,                
                'updated_by'     => $this->currentUser->user_id,
            ]);
            Session::flash('add-success', 'New dependent has been added successfully!');
            return redirect()->back();
        }
    }

    public function putDependent(Request $request, $employee_id)
    {
        if ($request->isDelete) {
            if (count($request->dependents) > 0) {
                foreach ($request->dependents as $dependent) {
                    tbl_dependents_model::find($dependent)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $put_dependent_rules = [
                'put_first_name' => 'required',
                'put_last_name' => 'required'];
            $put_dependent_msg = [
                'put_first_name.required' => 'First name is a required field.',
                'put_last_name.required' => 'Last name is a required field.'];
            $validator = Validator::make($request->all(), $put_dependent_rules, $put_dependent_msg);
            if ($validator->fails()) {
                Session::flash('put-failed', 'Failed to update dependent!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_dependents_model::find($request->put_dependent_id)->update([
                    'last_name'      => $request->put_last_name,
                    'first_name'     => $request->put_first_name,
                    'mid_name'       => $request->put_mid_name,
                    'dependent_type' => $request->put_dependent_type,
                    'gender'         => $request->put_gender,
                    'civil_stat'     => $request->put_civil_stat,
                    'date_birth'     => $request->put_date_birth,
                    'address'        => $request->put_address,
                    'occupation'     => $request->put_occupation,
                    'is_benef'       => $request->put_is_benef,
                    'is_tax_dep'     => $request->put_is_tax_dep,
                    'updated_by'     => $this->currentUser->user_id,
                ]);
                Session::flash('put-success', 'Employee dependent was been updated successfully!');
            }
        }
        return redirect()->back();        
    }

    public function getEducbackground($employee_id)
    {
        $employee  = tbl_employee_model::find($employee_id);
        $educ_back = tbl_education_background_model::where('employee_id', $employee->employee_id)->where('active_flag', 'Y')->orderBy('educ_type_id')->get();
        return view('main/employee/educational', ['employee' => $employee, 'educ_backs' => $educ_back]);
    }

    public function getEmploymenthistory($employee_id)
    {
        $employee  = tbl_employee_model::find($employee_id);
        $emp_hist = tbl_employment_history_model::where('employee_id', '=', $employee->employee_id)->where('active_flag', 'Y')->orderBy('company_name')->get();
        return view('main/employee/employmenthistory', ['employee' => $employee, 'emp_hist' => $emp_hist]);
    }

    public function postEducbackground(Request $request, $employee_id)
    {
        $add_educback_rules = [
             'educ_type_id' => 'required'
            ,'school_name' => 'required'];
        $add_educback_msg = [
             'educ_type_id.required' => 'Education level is a required field.'
            ,'school_name.required' => 'School name is a required field.'];
        $validator = Validator::make($request->all(), $add_educback_rules, $add_educback_msg);
        if ($validator->fails()) {
            Session::flash('add-failed', 'Failed to add new educational background!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_education_background_model::create([
                'employee_id'          => $employee_id,
                'educ_type_id'         => $request->educ_type_id,
                'school_name'          => $request->school_name,
                'school_address'       => $request->school_address,
                'period_attended_from' => $request->period_attended_from,
                "period_attended_to"   => $request->period_attended_to,
                'degree_earned'        => $request->degree_earned,
                'active_flag'          => 'Y',                
                'created_by'           => $this->currentUser->user_id,
                'updated_by'           => $this->currentUser->user_id,
            ]);
            Session::flash('add-success', 'New educational background has been added successfully!');
            return redirect()->back();
        }
    }

    public function postEmploymenthistory(Request $request, $employee_id)
    {
        $add_emphistory_rules = [
            'company_name' => 'required'];
        $add_emphistory_msg = [
            'company_name.required' => 'Company name is a required field.'];
        $validator = Validator::make($request->all(), $add_emphistory_rules, $add_emphistory_msg);
        if ($validator->fails()) {
            Session::flash('add-failed', 'Failed to add new employement history!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_employment_history_model::create([
                'employee_id'          => $employee_id,
                'company_name'         => $request->company_name,
                'address'              => $request->address,
                'period_attended_from' => $request->period_attended_from,
                'period_attended_to'   => $request->period_attended_to,
                'position_held'        => $request->position_held,
                'active_flag'          => 'Y',
                'created_by'           => $this->currentUser->user_id,
                'updated_by'           => $this->currentUser->user_id,
            ]);
            Session::flash('add-success', 'New employment history has been added successfully!');
            return redirect()->back();
        }
    }

    public function putBasicinformation(Request $request, $employee_id)
    {
        $put_profilebasic_rules = [
            'put_employee_number' => 'required',
            'put_first_name' => 'required',
            'put_last_name' => 'required',
            'put_middle_name' => 'required'];
        $put_profilebasic_msg = [
            'put_employee_number.required' => 'Employee number is a required field.',
            'put_first_name.required' => 'First name is a required field.',
            'put_last_name.required' => 'Last name is a required field.',
            'put_middle_name.required' => 'Middle name is a required field.'];
        $validator = Validator::make($request->all(), $put_profilebasic_rules, $put_profilebasic_msg);
        if ($validator->fails()) {
            Session::flash('put-failed', 'Failed to update employee basic information!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_employee_model::find($employee_id)->update([
                'salutation'  => $request->put_salutation,
                'first_name'  => $request->put_first_name,
                'last_name'   => $request->put_last_name,
                'middle_name' => $request->put_middle_name,
                'gender'      => $request->put_gender,
                'date_birth'  => $request->put_date_birth,
                'civil_stat'  => $request->put_civil_stat,
                'nationality' => $request->put_nationality,
                'active_flag' => $request->put_active_flag,
                'updated_by'  => $this->currentUser->user_id,
            ]);
            Session::flash('put-success', 'Employee basic information has been updated successfully!');
            return redirect()->back();
        }
    }

    public function putContactinformation(Request $request, $employee_id)
    {
        tbl_employee_model::find($employee_id)->update([
            'address1'   => $request->put_address1,
            'address2'   => $request->put_address2,
            'city'       => $request->put_city,
            'region'     => $request->put_region,
            'zip'        => $request->put_zip,
            'e_mail'     => $request->put_e_mail,
            'mobile_no'  => $request->put_mobile_no,
            'tel_no'     => $request->put_tel_no,
            'updated_by' => $this->currentUser->user_id,
        ]);
        Session::flash('put-success', 'Employee contact information has been updated successfully!');
        return redirect()->back();
    } // end of function

    public function putEmploymentdetails(Request $request, $employee_id)
    {
        tbl_employee_model::find($employee_id)->update([
            'payroll_group_id' => $request->put_payroll_group_id,
            'emp_type_id'  => $request->put_emp_type_id,
            'position_id'  => $request->put_position_id,
            'date_hired'   => date('Y-m-d', strtotime($request->put_date_hired)),
			'tax_code'      => $request->put_tax_code,		// 20161014 update from Hector Esquillo
            'date_regular' => empty($request->put_date_regular)? null : date('Y-m-d', strtotime($request->put_date_regular)),
            'updated_by'   => $this->currentUser->user_id,
        ]);
		
		/* 20161014 update from Hector Esquillo
			-Reason: Concerning addition of movement functionality
		*/
		/* 20161019 updated by Melvin Militante
			-Reason: When employment details is updated, it should not create additional rows, instead, it should update the active one
		*/
		if(DB::table('hr.tbl_movement')->count() > 0) {
			tbl_movement_model::where('employee_id', $employee_id)
				->where('active_flag', 'Y')
				->update(
					['position_id'		=> $request-> put_position_id
					,'tax_code'     	=> $request->put_tax_code
					,'updated_by'		=> $this->currentUser->user_id,]
				)
			;
		} else {
			tbl_movement_model::create(
				['employee_id'		=> $employee_id
				//,'effective_date'	=> date('Y-m-d', strtotime($request->put_date_hired))
				,'effective_date'	=> date('Y-m-d')
				,'employee_status'	=> $request->put_emp_type_id
				,'position_id'		=> $request-> put_position_id
				,'tax_code'     	=> $request->put_tax_code
				,'business_unit_id'	=> \App\tbl_business_unit_model::where('business_unit_id',  \App\tbl_position_model::where('position_id',  $request-> put_position_id)->first()->business_unit_id)->first()->business_unit_id
				,'grade_id'			=> \App\tbl_salary_grade_model::where('grade_id',  \App\tbl_position_model::where('position_id', $request-> put_position_id)->first()->grade_id)->first()->grade_id
				,'class_id'			=>\App\tbl_classification_model::where('class_id',  \App\tbl_position_model::where('position_id', $request-> put_position_id)->first()->class_id)->first()->class_id
				,'active_flag'		=> 'Y'
				,'remarks'			=> 'Initial movement'
				,'created_by'		=> $this->currentUser->user_id
				,'company_id'		=> $this->currentCompany->company_id,]
			);
		}
		/* 20161019 end of update */
		/* 20161014 end of update */
		
        Session::flash('put-success', 'Employee employement details has been updated successfully!');
        return redirect()->back();
    } // end of function

    public function putGovernmentdetails(Request $request, $employee_id)
    {
        tbl_employee_model::find($employee_id)->update([
            'sss_no'        => $request->put_sss_no,
            'tin_no'        => $request->put_tin_no,
            'philhealth_no' => $request->put_philhealth_no,
            'hdmf_no'       => $request->put_hdmf_no,
            'rdo_no'        => $request->put_rdo_no,
            //'tax_code'      => $request->put_tax_code,	// 20161014 update from Hector Esquillo
            'updated_by'    => $this->currentUser->user_id,
        ]);
        Session::flash('put-success', 'Employee government details has been updated successfully!');
        return redirect()->back();
    }

    public function putEducbackground(Request $request, $employee_id)
    {
        if ($request->isDelete) {
            if (count($request->educbacks) > 0) {
                foreach ($request->educbacks as $educback) {
                    tbl_education_background_model::find($educback)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $put_educbacks_rules = [
                'put_school_name' => 'required'];
            $put_educbacks_msg = [
                'put_school_name.required' => 'School name is a required field.'];
            $validator = Validator::make($request->all(), $put_educbacks_rules, $put_educbacks_msg);
            if ($validator->fails()) {
                $request->session()->flash('put-failed', 'Failed to update educational background!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_education_background_model::find($request->put_educ_back_id)->update([
                    'educ_type_id'         => $request->put_educ_type_id,
                    'school_name'          => $request->put_school_name,
                    'school_address'       => $request->put_school_address,
                    'period_attended_from' => $request->put_period_attended_from,
                    "period_attended_to"   => $request->put_period_attended_to,
                    'degree_earned'        => $request->put_degree_earned,
                    'updated_by'           => $this->currentUser->user_id,
                ]);
                Session::flash('put-success', 'Employee educational background was been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function putEmploymenthistory(Request $request, $employee_id)
    {
        if ($request->isDelete) {
            if (count($request->emphistories) > 0) {
                foreach ($request->emphistories as $emphistory) {
                    tbl_employment_history_model::find($emphistory)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $put_emphistories_rules = [
                'put_company_name' => 'required'];
            $put_emphistories_msg = [
                'put_company_name.required' => 'Company name is a required field.'];
            $validator = Validator::make($request->all(), $put_emphistories_rules, $put_emphistories_msg);
            if ($validator->fails()) {
                $request->session()->flash('put-failed', 'Failed to update employement history!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                tbl_employment_history_model::find($request->put_emp_hist_id)->update([
                    'company_name'         => $request->put_company_name,
                    'address'              => $request->put_address,
                    'period_attended_from' => $request->put_period_attended_from,
                    'period_attended_to'   => $request->put_period_attended_to,
                    'position_held'        => $request->put_position_held,
                    'updated_by'           => $this->currentUser->user_id,
                ]);
                $request->session()->flash('put-success', 'Employee Employment history was been updated!');
            }
        }
        return redirect()->back();
    }

    //  upload image
    public function postUploadimg($employee_id)
    {
        // getting all of the post data
        $file = array('image' => Input::file('image'));
        // setting up rules
        $rules = array('image' => 'required'); //mimes:jpeg,bmp,png and for max size max:100000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);

        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return redirect('upload_img')->withInput()->withErrors($validator);
        } else {
            // checking if file is valid.
            if (Input::file('image')->isValid()) {
                $destinationPath = 'images/emp_image/'; // upload path
                $extension       = Input::file('image')->getClientOriginalExtension(); // getting image extension
                $fileName        = $employee_id . '.' . $extension; // renameing image
                Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
                // sending back with message
                Session::flash('success', 'Upload successfully');
                tbl_employee_model::
                    find($employee_id)
                    ->update(['emp_photo' => $destinationPath . $employee_id . '.' . $extension,]);
            } else {
                Session::flash('error', 'uploaded file is not valid');
            }
            return redirect()->back();            
        }
    }

    public function getMovements() 
	{
        $movements = tbl_employee_model::
            where('company_id', $this->currentCompany->company_id)
				->where('active_flag', 'Y')
				->orderBy('employee_number')
				->get();
        return view('main.employee.movement', ['movements' => $movements]);
    }

    public function getMovementsofemployee($employee_id) {
        $movementsofemployee = tbl_movement_model::
            where('company_id', $this->currentCompany->company_id)
            //->where('active_flag', 'Y')		// 20161014 update from Hector Esquillo
				->where('employee_id', $employee_id)
				->orderBy('effective_date', 'desc')
				->orderBy('created_at', 'desc')
				->get();
		/* 20161014 update from Hector Esquillo
			-Reason: Concerning addition of movement functionality
		*/
		$company = tbl_company_model::
			where('active_flag','Y')
				->get();
		$employee_types = tbl_employee_type_model::
			where('company_id', $this->currentCompany->company_id)
				->where('active_flag', 'Y')
				->orderBy('emp_type_id')
				->get();
		/* 20161014 end of update */
        $positions = tbl_position_model::
            where('company_id', $this->currentCompany->company_id)
				->where('active_flag', 'Y')
				->orderBy('description')
				->get();
		/* 20161014 update from Hector Esquillo
			-Reason: Concerning addition of movement functionality
		*/
		$buss_units=tbl_business_unit_model::
			where('company_id', $this->currentCompany->company_id)
				->where('active_flag', 'Y')
				->get();
		$sal_grades=tbl_salary_grade_model::
			where('company_id', $this->currentCompany->company_id)
				->where('active_flag', 'Y')
				->get();
		$classifications=tbl_classification_model::
			where('company_id', $this->currentCompany->company_id)
				->where('active_flag', 'Y')
				->get();
		/* 20161014 end of update */
        $tax_codes = tbl_tax_code_model::
            where('company_id', $this->currentCompany->company_id)
            ->where('active_flag', 'Y')
            ->orderBy('description')
            ->get();
        $employee = tbl_employee_model::find($employee_id);
		/* 20161014 update from Hector Esquillo
			-Reason: Concerning addition of movement functionality
		*/
		$employee_list   = \App\tbl_employee_model::select(
			DB::raw("first_name || ' ' || last_name || ' (' || employee_number || ')' as employee, employee_id"))
				->where('active_flag', 'Y')
				->where('company_id', $this->currentCompany->company_id)
				->orderBy('employee')
				->lists('employee', 'employee_id')
				->toArray();
        return view('main.employee.movementofemployee', 
			['movementsofemployee'	=> $movementsofemployee
			,'employee'				=> $employee
			,'employee_list'		=> $employee_list
            ,'positions'			=> $positions
			,'buss_units'			=> $buss_units
			,'sal_grades'			=> $sal_grades
			,'classifications'		=> $classifications
			,'company'				=> $company
			,'employee_types'		=> $employee_types
            ,'tax_codes'			=> $tax_codes]
		);
		/* 20161014 end of update */
    }
	
	/* 20161014 update from Hector Esquillo
		-Reason: Concerning addition of movement functionality
	*/
	public function postMovementsofemployee(Request $request, $employee_id)
	{
		/* 20161020 updated by Melvin Militante
			-Reason: When creating a movement for an employee with effective date less than or equal current date, the program should deactivate other movements
					of the employee then create an active one. If a future effective date is selected, create an inactive movement entry and push a job for the
					queue to process when provided effective date is reached.
			-To Do:
				- Create a job to push to the queue when an future effective date is provided.
				- Catch the error where a movement created should not have an effective date less than the current active movement for the employee.
		*/
		if ( DateTime::createFromFormat('m/d/Y', $request->effective_date) <= DateTime::createFromFormat('m/d/Y', date('m/d/Y')) ) {
			
			tbl_movement_model::where('employee_id', $employee_id)
				->where('active_flag', 'Y')
				->update(
					['active_flag' => 'N']
				);
			
			tbl_movement_model:: create(
				['employee_id'				=> $employee_id
				,'company_id'				=> $request->company_id
				,'effective_date'			=> $request->effective_date
				,'employee_status'			=> $request->emp_type_id
				,'position_id'				=> $request->position_id
				,'tax_code'     			=> $request->tax_code
				,'basic_amt'				=> $request->basic_amt
				,'business_unit_id' 		=> $request->business_unit_id
				,'grade_id'					=> $request->grade_id
				,'class_id'					=> $request->class_id
				,'salary_type'				=> $request->put_salary_type
				,'payroll_type_id_basic'	=> '1'
				,'authorized_by'			=> $request->authorized_by
				,'prepared_by'				=> $request-> prepared_by
				,'recommend_by'				=> $request->recommend_by
				,'active_flag'				=> 'Y'
				,'remarks'					=> $request->remarks
				,'created_by'      			=> $this->currentUser->user_id]
			);
			
		} else {
			
			tbl_movement_model:: create(
				['employee_id'				=> $employee_id
				,'company_id'				=> $request->company_id
				,'effective_date'			=> $request->effective_date
				,'employee_status'			=> $request->emp_type_id
				,'position_id'				=> $request->position_id
				,'tax_code'     			=> $request->tax_code
				,'basic_amt'				=> $request->basic_amt
				,'business_unit_id' 		=> $request->business_unit_id
				,'grade_id'					=> $request->grade_id
				,'class_id'					=> $request->class_id
				,'salary_type'				=> $request->put_salary_type
				,'payroll_type_id_basic'	=> '1'
				,'authorized_by'			=> $request->authorized_by
				,'prepared_by'				=> $request-> prepared_by
				,'recommend_by'				=> $request->recommend_by
				,'active_flag'				=> 'N'
				,'remarks'					=> $request->remarks
				,'created_by'      			=> $this->currentUser->user_id]
			);
			
			// TODO: create process to push a job here to the queue
		}
		
		/* 20161020 end of update */
        
		Session::flash('put-success', 'Employee employment details has been updated successfully!');
        return redirect()->back();
		
	}
	public function putMovementsofemployee(Request $request, $employee_id)
	{
		tbl_movement_model:: find($request->movement_id)->update(
			['effective_date'	=> $request->put_effective_date
			,'employee_status'	=> $request->put_emp_type_id
			,'position_id'		=> $request->put_position_id
			,'tax_code'      	=> $request->put_tax_code
			,'basic_amt'		=> $request->put_basic_amt
			,'business_unit_id'	=> $request->put_business_unit_id
			,'grade_id'			=> $request->put_grade_id
			,'class_id'			=> $request->put_class_id
			,'salary_type'		=> $request->put_salary_type
			,'authorized_by'	=> $request->put_authorized_by
			,'prepared_by'		=> $request->put_prepared_by
			,'recommend_by'		=> $request->put_recommend_by
			,'active_flag'  	=> 'Y'
			,'created_by'   	=> $this->currentUser->user_id
			,'company_id'      	=> $this->currentCompany->company_id,
			]
		);
		Session::flash('put-success', 'Movement details has been updated successfully!');
        return redirect()->back();

	}
	/* 20161014 end of update */
}
