<?php

namespace App\Http\Controllers;

use App\Http\Classes\AutoSeed;
use App\tbl_company_model;
use App\tbl_employee_type_model;
use App\tbl_position_model;
use App\tbl_salary_grade_model;
use App\tbl_unit_location_model;
use App\tbl_user_company_model;
use Auth;
use Illuminate\Http\Request;
use Session;
use Validator;

class CompanySetupController extends Controller
{
//
    public function get_companies()
    {
        $companies = tbl_company_model::
              where('active_flag', 'Y')
            ->whereIn('company_id', tbl_user_company_model::
                  where('user_id', $this->currentUser->user_id)
                ->lists('company_id')
                ->toArray())
            ->orderBy('company_name')->get();
        return view('main/admin/companies', ['companies' => $companies]);
    }

    public function get_details($company_id)
    {
        $company = tbl_company_model::find($company_id);
        return view('main/company_setup/companydetails', ['company' => $company]);
    }

    public function get_locations($company_id)
    {
        $company   = tbl_company_model::find($company_id);
        $locations = tbl_unit_location_model::where('company_id', $company->company_id)
            ->where('active_flag', 'Y')
            ->orderby('location_code')->get();
        return view('main/company_setup/location', [
              'locations' => $locations
            , 'company' => $company]);
    }

    public function get_employmenttypes($company_id)
    {
        $company           = tbl_company_model::find($company_id);
        $employement_types = tbl_employee_type_model::where('company_id', $company->company_id)
            ->where('active_flag', 'Y')
            ->orderby('emp_type_name')->get();
        return view('main/company_setup/employementtype', [
            'employement_types' => $employement_types
            , 'company' => $company]);
    }

    public function get_salarygrades($company_id)
    {
        $company       = tbl_company_model::find($company_id);
        $salary_grades = tbl_salary_grade_model::where('company_id', $company_id)
            ->where('active_flag', 'Y')
            ->orderby('grade_name')->get();
        return view('main/company_setup/salarygrade', [
            'salary_grades' => $salary_grades
            , 'company' => $company]);
    }

    public function get_positions($company_id)
    {
        $company   = tbl_company_model::find($company_id);
        $positions = tbl_position_model::where('company_id', '=', $company_id)
            ->where('active_flag', 'Y')
            ->orderby('position_code')->get();
        return view('main/company_setup/position', [
            'positions' => $positions
            , 'company' => $company]);
    }

    public function add_companies(Request $request)
    {
        $add_company_rules = [
            'company_name' => 'required'];
        $add_company_msg = [
            'company_name.required' => 'Company name is a required field.'];
			
        $validator = Validator::make($request->all(), $add_company_rules, $add_company_msg);
        if ($validator->fails()) {
            Session::flash('add-failed', 'Failed to add new company!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $company = tbl_company_model::create([
                'company_name' => $request->company_name,
                'address'      => $request->address,
                'city'         => $request->city,
                'region'       => $request->region,
                'zip'          => $request->zip,
                'contact_no'   => $request->contact_no,
                'created_by'   => $this->currentUser->user_id,
                'updated_by'   => $this->currentUser->user_id,
                'active_flag'  => 'Y',
            ]);

            tbl_user_company_model::create([
                'user_id'    => $this->currentUser->user_id,
                'company_id' => $company->company_id,
                'created_by' => $this->currentUser->user_id,
                'updated_by' => $this->currentUser->user_id,
            ]);
			
			dd($company);
			
			$autoSeed = new AutoSeed();
			$autoSeed->company_autoseed($company);

            Session::flash('add-success', 'New company has been added successfully!');
            return redirect()->back();
        }
    }

    public function add_locations(Request $request, $company_id)
    {
        $add_location_rules = [
            'location_code' => 'required'];
        $add_location_msg = [
            'location_code.required' => 'Location code is a required field.'];
        $validator = Validator::make($request->all(), $add_location_rules, $add_location_msg);
        if ($validator->fails()) {
            Session::flash('add-failed', 'Failed to add new location details!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_unit_location_model::create([
                'company_id' => $company_id
                , 'location_code' => $request->location_code
                , 'location_name' => $request->location_name
                , 'address1' => $request->address
                , 'city' => $request->city
                , 'active_flag' => 'Y'
                , 'created_by' => $this->currentUser->user_id
                , 'updated_by' => $this->currentUser->user_id
            ]);
            Session::flash('add-success', 'New location has been added successfully!');
            return redirect()->back();
        }
    }

    public function add_employmenttypes(Request $request, $company_id)
    {
        $add_employment_type_rules = [
            'emp_type_name' => 'required'];
        $add_employment_type_msg = [
            'emp_type_name.required' => 'Employement type name is a required field.',
        ];
        $validator = Validator::make($request->all(), $add_employment_type_rules, $add_employment_type_msg);
        if ($validator->fails()) {
            Session::flash('add-failed', 'Failed to add new employement type!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_employee_type_model::create([
                'company_id' => $company_id
                , 'emp_type_name' => $request->emp_type_name
                , 'min_hrs' => $request->min_hrs
                , 'max_hrs' => $request->max_hrs
                , 'active_flag' => 'Y'
                , 'created_by' => $this->currentUser->user_id
                , 'updated_by' => $this->currentUser->user_id
            ]);
            $request->session()->flash('add-success', 'New employement type has been added successfully!');
            return redirect()->back();
        }
    }

    public function add_salarygrades(Request $request, $company_id)
    {

        $add_salary_grade_rules = [
            'grade_name' => 'required'];
        $add_salary_grade_msg = [
            'grade_name.required' => 'Grade name is a required field.'];
        $validator = Validator::make($request->all(), $add_salary_grade_rules, $add_salary_grade_msg);
        if ($validator->fails()) {
            Session::flash('add-failed', 'Failed to add new salary grade!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_salary_grade_model::create([
                'company_id' => $request->company_id
                , 'grade_name' => $request->grade_name
                , 'minimum_salary' => $request->minimum_salary
                , 'maximum_salary' => $request->maximum_salary
                , 'active_flag' => 'Y'
                , 'created_by' => $this->currentUser->user_id
                , 'updated_by' => $this->currentUser->user_id
            ]);
            Session::flash('add-success', 'New salary grade has been added successfully!');
            return redirect()->back();
        }
    }

    public function add_positions(Request $request, $company_id)
    {

        $add_position_rules = [
            'position_code' => 'required'];
        $add_position_msg = [
            'position_code.required' => 'Position code is a required field.'];
        $validator = Validator::make($request->all(), $add_position_rules, $add_position_msg);
        if ($validator->fails()) {
            $request->session()->flash('add-failed', 'Failed to add new position!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            tbl_position_model::create([
                'company_id' => $request->company_id
                , 'position_code' => $request->position_code
                , 'description' => $request->description
                , 'business_unit_id' => $request->business_unit_id
                , 'grade_id' => $request->grade_id
                , 'class_id' => $request->class_id
                , 'active_flag' => 'Y'
                , 'created_by' => $this->currentUser->user_id
                , 'updated_by' => $this->currentUser->user_id
            ]);
            Session::flash('add-success', 'New position has been added successfully!');
            return redirect()->back();
        }
    }

    public function put_details(Request $request, $company_id)
    {
        $put_company_rules = [
            'put_company_name' => 'required'];
        $put_company_msg = [
            'put_company_name.required' => 'Company name is a required field.'];
        $validator = Validator::make($request->all(), $put_company_rules, $put_company_msg);
        if ($validator->fails()) {
            Session::flash('put-failed', 'Failed to update new company!');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $company      = tbl_company_model::find($company_id);
            $company->update([
                'address' => $request->put_address
                , 'city' => $request->put_city
                , 'region' => $request->put_region
                , 'zip' => $request->put_zip
                , 'contact_no' => $request->put_contact_no
                , 'bir_reg_no' => $request->put_bir_reg_no
                , 'sss_no' => $request->put_sss_no
                , 'tin_no' => $request->put_tin_no
                , 'philhealth_no' => $request->put_philhealth_no
                , 'hdmf_no' => $request->put_hdmf_no
                , 'bir_rdo_no' => $request->put_bir_rdo_no
                , 'updated_by' => $this->currentUser->user_id,
            ]);
            $request->session()->flash('put-success', 'Company has been updated successfully!');
            return redirect()->back();
        }
    }

    public function put_locations(Request $request, $company_id)
    {
        if ($request->isDelete) {
            if (count($request->locations) > 0) {
                foreach ($request->locations as $location) {
                    tbl_unit_location_model::find($location)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $put_location_rules = [
                'put_location_code' => 'required'];
            $put_location_msg = [
                'put_location_code.required' => 'Location code is a required field.'];
            $validator = Validator::make($request->all(), $put_location_rules, $put_location_msg);
            if ($validator->fails()) {
                Session::flash('put-failed', 'Failed to update location details!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $location = tbl_unit_location_model::find($request->put_location_id)->update([
                    'location_code' => $request->put_location_code
                    , 'location_name' => $request->put_location_name
                    , 'address1' => $request->put_address
                    , 'city' => $request->put_city
                    , 'updated_by' => $this->currentUser->user_id,
                ]);
                Session::flash('put-success', 'location details was been updated!');
            }
        }
        return redirect()->back();        
    }

    public function put_employmenttypes(Request $request, $company_id)
    {
        if ($request->isDelete) {
            if (count($request->employmenttypes) > 0) {
                foreach ($request->employmenttypes as $employmenttype) {
                    tbl_employee_type_model::find($employmenttype)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {
            $put_employment_type_rules = [
                'put_emp_type_name' => 'required'];
            $put_employment_type_msg = [
                'put_emp_type_name.required' => 'Employement type name is a required field.'];
            $validator = Validator::make($request->all(), $put_employment_type_rules, $put_employment_type_msg);
            if ($validator->fails()) {
                Session::flash('put-failed', 'Failed to update employement type!');
                return redirect('home/admin/companysetup/' . $company_id . '/employmenttype')->withErrors($validator)->withInput();
            } else {
                $employment_type = tbl_employee_type_model::find($request->put_emp_type_id)->update([
                    'emp_type_name' => $request->put_emp_type_name
                    , 'min_hrs' => $request->put_min_hrs
                    , 'max_hrs' => $request->put_max_hrs
                    , 'updated_by' => $this->currentUser->user_id,
                ]);
                Session::flash('put-success', 'Employement type has been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function put_salarygrades(Request $request, $company_id)
    {
        if ($request->isDelete) {
            if (count($request->salarygrades) > 0) {
                foreach ($request->salarygrades as $salarygrade) {
                    tbl_salary_grade_model::find($salarygrade)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {

            $put_salary_grade_rules = [
                'put_grade_name' => 'required'];
            $put_salary_grade_msg = [
                'put_grade_name.required' => 'Grade name is a required field.'];
            $validator = Validator::make($request->all(), $put_salary_grade_rules, $put_salary_grade_msg);
            if ($validator->fails()) {
                Session::flash('put-failed', 'Failed to update salary grade!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $salary_grade = tbl_salary_grade_model::find($request->put_grade_id)->update([
                    'grade_name' => $request->put_grade_name
                    , 'minimum_salary' => $request->put_minimum_salary
                    , 'maximum_salary' => $request->put_maximum_salary
                    , 'updated_by' => $this->currentUser->user_id,
                ]);
                Session::flash('put-success', 'Salary grade has been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function put_positions(Request $request, $company_id)
    {
        if ($request->isDelete) {
            if (count($request->positions) > 0) {
                foreach ($request->positions as $position) {
                    tbl_salary_grade_model::find($position)->update([
                        'active_flag' => 'N',
                        'updated_by'  => $this->currentUser->user_id,
                    ]);
                }
                Session::flash('del-success', 'Records selected have been deleted successfully.');
            } else {
                Session::flash('del-warning', 'No selected records found! Nothing to delete.');
            }
        } else {

            $put_position_rules = [
                'put_position_code' => 'required'];
            $put_position_msg = [
                'put_position_code.required' => 'Position code is a required field.'];
            $validator = Validator::make($request->all(), $put_position_rules, $put_position_msg);
            if ($validator->fails()) {
                $request->session()->flash('put-failed', 'Failed to update position!');
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $position = tbl_position_model::find($request->put_position_id)->update([
                    'position_code' => $request->put_position_code
                    , 'description' => $request->put_description
                    , 'business_unit_id' => $request->put_business_unit_id
                    , 'grade_id' => $request->put_grade_id
                    , 'class_id' => $request->put_class_id
                    , 'updated_by' => $this->currentUser->user_id,
                ]);
                Session::flash('put-success', 'Position has been updated successfully!');
            }
        }
        return redirect()->back();
    }

    public function del_companies(Request $request)
    {
        if (count($request->companies) > 0) {
            foreach ($request->companies as $company) {
                tbl_company_model::find($company)->update([
                    'active_flag' => 'N',
                    'updated_by'  => Auth::user()->user_id,
                ]);
            }
            $request->session()->flash('del-success', 'Records selected have been deleted successfully.');
        } else {
            $request->session()->flash('del-warning', 'No selected records found! Nothing to delete.');
        }
        return redirect()->back();        
    }

    public function get_change_company()
    {
        $companies = \App\tbl_company_model::
                                    whereIn('company_id', \App\tbl_user_company_model::
                                        where('user_id', Auth::user()->user_id)
                                        ->lists('company_id')
                                        ->toArray())
                                ->where('active_flag', 'Y')
                                ->orderBy('updated_at', 'desc')
                                ->orderBy('company_id', 'desc')
                                ->get();
        return view('main.admin/changecompany', ['companies' => $companies]);
    }

    public function get_change_company2($company_id)
    {
        tbl_user_company_model::where('user_id', $this->currentUser->user_id)->where('default_flag', 'Y')->update(['default_flag' => '']);
        tbl_user_company_model::where('company_id', $company_id)->update(['default_flag' => 'Y', 'updated_by' => $this->currentUser->user_id]);
        return redirect()->back();
    }

    public function post_change_company(Request $request)
    {
        tbl_user_company_model::where('company_id', $request->old_company_id)->update(['default_flag' => '', 'updated_by' => $this->currentUser->user_id]);
        tbl_user_company_model::where('company_id', $request->new_company_id)->update(['default_flag' => 'Y', 'updated_by' => $this->currentUser->user_id]);
        Session::flash('change-success', 'Company has been changed succesfully.');
        return redirect()->back();
    }    
}
