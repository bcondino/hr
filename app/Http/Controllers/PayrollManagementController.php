<?php

namespace App\Http\Controllers;

use App\Jobs\PayrollJob;
use App\tbl_payroll_earndedn_model;
use App\tbl_payroll_element_model;
use App\tbl_payroll_group_model;
use App\tbl_payroll_mode_model;
use App\tbl_payroll_period_model;
use App\tbl_payroll_process_model;
use App\tbl_payroll_profile_model;
use App\tbl_recur_earndedn_model;
use App\tbl_report_model;
use App\tbl_report_param_model;
use DB;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use Validator;
use DateTime;

class PayrollManagementController extends Controller {

	public function recurring() {
		$entry_type = Input::get('entry_type');
		$payroll_elements = tbl_payroll_element_model::
			where('company_id', $this->currentCompany->company_id)
			->where('active_flag', 'Y')
			->where('entry_type', $entry_type)
			->orderBy('description')
			->get();
		return $payroll_elements;
	}

	public function repdetail() {
		$report_id = Input::get('report_id');
		$report_details = tbl_report_model::
			where('report_id', $report_id)
			->get()
			->first();
		return $report_details;
	}

	public function repparam() {
		$report_id = Input::get('report_id');
		$report_params = tbl_report_param_model::
			where('report_id', $report_id)
			->orderBy('report_param_id')
			->get();
		$toReturn = '<div class="uk-form-row"><b>Parameters:</b></div>';

		$param_seq = 0;

		foreach ($report_params as $param) {

			$toReturn = $toReturn.'<div class="uk-form-row"><label class="uk-form-label">';

			if ($param->required_flag=='Y') {
				$toReturn = $toReturn.'<span class="uk-text-danger">*</span>';
			}

			$toReturn = $toReturn.$param->param_name;
			$toReturn = $toReturn.'</label><div class="uk-form-controls">';
			$test = '';

			if ( $param->param_type == 'SQL' ) {

				if ($param->required_flag=='Y') {
					$toReturn = $toReturn.'<select id="'.$param_seq.'" name="p'.$param_seq.'" required>';
				} else {
					$toReturn = $toReturn.'<select id="'.$param_seq.'" name="p'.$param_seq.'">';
				}

				$param_query = str_replace('[USER_ID]', $this->currentUser->user_id, $param->selection);
				$param_values = db::select(db::raw($param_query));
				$toReturn = $toReturn.'<option value="">-- Select --</option>';
				
				foreach ($param_values as $param_value) {
					$toReturn = $toReturn.'<option value="'.$param_value->id.'">'.$param_value->name.'</option>';
				}

				$toReturn = $toReturn.'</select>';

			}

			$toReturn = $toReturn.'</div></div>';

			$param_seq++;

		}

		return $toReturn;
	
	}

	public function payrollperiod() {
		$payroll_mode = Input::get('payrollmode');
		$year = Input::get('year');
		$payroll_period = tbl_payroll_period_model::
			where('company_id', $this->currentCompany->company_id)
			->where('active_flag', 'Y')
			->where('year', $year)
			->where('payroll_mode', $payroll_mode)
			->orderBy('month')
			->get();
		return $payroll_period;
	}

	public function getProfile() {
		$profiles = tbl_payroll_profile_model::where('company_id', $this->currentCompany->company_id)->where('active_flag', 'Y')->get();
		return view('main.payrollmanagement.profile', ['profiles' => $profiles, 'company' => $this->currentCompany]);
	}

	public function postProfile(Request $request) {
		$post_profile_rule = [
			'payroll_group_id' => 'required',
			'sub_filing_flag' => 'required',
			'ded_sss_flag' => 'required',
			'ded_pagibig_flag' => 'required',
			'ded_philhealth_flag' => 'required',
			'ded_sss_basic_flag' => 'required',
			'ded_pagibig_basic_flag' => 'required',
			'ded_philhealth_basic_flag' => 'required'];
		$post_profile_msg = [
			'payroll_group_id.required' => 'Payroll group is a required field.'];
		$validator = Validator::make($request->all(), $post_profile_rule, $post_profile_msg);
		if ($validator->fails()) {
			Session::flash('add-failed', 'Failed to add input details!');
			return redirect()->back()->withErrors($validator)->withInput();
		} else {
			tbl_payroll_profile_model::create([
				'payroll_group_id' => $request->payroll_group_id
				, 'payroll_mode' => tbl_payroll_group_model::find($request->payroll_group_id)->payroll_mode
				, 'tax_fix_amt' => empty($request->tax_fix_amt) ? 0 : $request->tax_fix_amt
				, 'add_tax_amt' => empty($request->add_tax_amt) ? 0 : $request->add_tax_amt
				, 'sub_filing_flag' => $request->sub_filing_flag
				, 'ded_sss_flag' => $request->ded_sss_flag
				, 'ded_gsis_flag' => 'N' // default No
				, 'ded_pagibig_flag' => $request->ded_pagibig_flag
				, 'pagibig_fix_amt' => empty($request->pagibig_fix_amt) ? 0 : $request->pagibig_fix_amt
				, 'ded_philhealth_flag' => $request->ded_philhealth_flag
				, 'ded_sss_basic_flag' => $request->ded_sss_basic_flag
				, 'ded_gsis_basic_flag' => 'N'
				, 'ded_pagibig_basic_flag' => $request->ded_philhealth_flag
				, 'ded_philhealth_basic_flag' => $request->ded_philhealth_basic_flag
				, 'ded_sss_sb_amt' => empty($request->ded_sss_sb_amt) ? 0 : $request->ded_sss_sb_amt
				, 'ded_gsis_sb_amt' => 0
				, 'ded_pagibig_sb_amt' => empty($request->ded_pagibig_sb_amt) ? 0 : $request->ded_philhealth_sb_amt
				, 'ded_philhealth_sb_amt' => empty($request->ded_philhealth_sb_amt) ? 0 : $request->ded_philhealth_sb_amt
				, 'created_by' => $this->currentUser->user_id
				, 'updated_by' => $this->currentUser->user_id
				, 'status' => 0
				, 'company_id' => $this->currentCompany->company_id,
			]);
			Session::flash('add-success', 'New payroll profile has been added successfully');
			return redirect()->back();
		}
	}

	public function putProfile(Request $request) {
		if ($request->isDelete) {
			if (count($request->profiles) > 0) {
				foreach ($request->profiles as $profile) {
					tbl_payroll_profile_model::find($profile)->update([
						'active_flag' => 'N',
						'updated_by' => $this->currentUser->user_id,
					]);
				}
				Session::flash('del-success', 'Records selected have been deleted successfully.');
			} else {
				Session::flash('del-warning', 'No selected records found! Nothing to delete.');
			}
		} else {
			$put_profile_rule = [
				'put_payroll_group_id' => 'required'];
			$put_profile_msg = [
				'put_payroll_group_id.required' => 'Payroll group is a required field.'];
			$validator = Validator::make($request->all(), $put_profile_rule, $put_profile_msg);
			if ($validator->fails()) {
				Session::flash('put-failed', 'Failed to add input details!');
				return redirect()->back()->withErrors($validator)->withInput();
			} else {
				tbl_payroll_profile_model::
					where('payroll_profile_id', $request->put_payroll_profile_id)
					->update([
						'payroll_group_id' => $request->put_payroll_group_id
						, 'tax_fix_amt' => empty($request->put_tax_fix_amt)? 0 : $request->put_tax_fix_amt
						, 'add_tax_amt' => empty($request->put_add_tax_amt)? 0 : $request->put_add_tax_amt
						, 'sub_filing_flag' => $request->put_sub_filing_flag
						, 'ded_sss_flag' => $request->put_ded_sss_flag
						, 'ded_pagibig_flag' => $request->put_ded_pagibig_flag
						, 'pagibig_fix_amt' => empty($request->put_pagibig_fix_amt)? 0 : $request->put_pagibig_fix_amt
						, 'ded_philhealth_flag' => $request->put_ded_philhealth_flag
						, 'ded_sss_basic_flag' => $request->put_ded_sss_basic_flag
						, 'ded_pagibig_basic_flag' => $request->put_ded_philhealth_flag
						, 'ded_philhealth_basic_flag' => $request->put_ded_philhealth_basic_flag
						, 'ded_sss_sb_amt' => empty($request->put_ded_sss_sb_amt)? 0 : $request->put_ded_sss_sb_amt
						, 'ded_pagibig_sb_amt' => empty($request->put_ded_pagibig_sb_amt)? 0 : $request->put_ded_pagibig_sb_amt
						, 'ded_philhealth_sb_amt' => empty($request->put_ded_philhealth_sb_amt)? 0 : $request->put_ded_philhealth_sb_amt
						, 'updated_by' => $this->currentUser->user_id,
					]);
				Session::flash('put-success', 'New payroll profile has been added successfully');
			}
		}
		return redirect()->back();
	}

	public function getRearningsdedn() {
		
		$rearndedns = tbl_recur_earndedn_model::
			where('active_flag', 'Y')
			->whereIn('employee_id',
				\App\tbl_employee_model::
					where('company_id', $this->currentCompany->company_id)
					->where('active_flag', 'Y')
					->lists('employee_id'))
			->get();

		$employee = \App\tbl_employee_model::select(
			DB::raw("first_name || ' ' || last_name || ' (' || employee_number || ')' as employee, employee_id"))
			->where('active_flag', 'Y')
			->where('company_id', $this->currentCompany->company_id)
			->lists('employee', 'employee_id')
			->toArray();
		$payroll_element = \App\tbl_payroll_element_model::
			where('company_id', $this->currentCompany->company_id)
			->where('active_flag', 'Y')
			->get();
		return view('main.payrollmanagement.rearndedn'
			, ['rearndedns' => $rearndedns
				, 'employee' => $employee
				, 'payroll_element' => $payroll_element]);
	}

	public function postRearningsdedn(Request $request) {
		$post_profile_rule = [
			'employee_id' => 'required'];
		$post_profile_msg = [
			'employee_id.required' => 'Employee number is a required field.'];
		$validator = Validator::make($request->all(), $post_profile_rule, $post_profile_msg);
		if ($validator->fails()) {
			Session::flash('add-failed', 'Failed to add input details!');
			return redirect()->back()->withErrors($validator)->withInput();
		} else {
			tbl_recur_earndedn_model::create([
				'employee_id' => $request->employee_id
				, 'payroll_element_id' => $request->payroll_element_id
				, 'dbcr_mode' => $request->dbcr_mode
				, 'amount' => empty($request->amount) ? 0 : $request->amount
				, 'date_start' => DateTime::createFromFormat('m/d/Y', $request->date_start)->format('Y-m-d')
				, 'date_end' => DateTime::createFromFormat('m/d/Y', $request->date_end)->format('Y-m-d')
				, 'status' => $request->status
				, 'payment_ctr' => empty($request->payment_ctr) ? 0 : $request->payment_ctr
				, 'created_by' => $this->currentUser->user_id
				, 'updated_by' => $this->currentUser->user_id,
			]);
			Session::flash('add-success', 'New recurring earnings and deductions has been added successfully.');
			return redirect()->back();
		}
	}

	public function putRearningsdedn(Request $request) {

		if ($request->isDelete) {
			if (count($request->earndedns) > 0) {
				foreach ($request->earndedns as $earndedns) {
					tbl_recur_earndedn_model::find($earndedns)->update([
						'active_flag' => 'N',
						'updated_by' => $this->currentUser->user_id,
					]);
				}
				Session::flash('del-success', 'Records selected have been deleted successfully.');
			} else {
				Session::flash('del-warning', 'No selected records found! Nothing to delete.');
			}
		} else {
			$put_rearndedn_rule = [
				'employee_id' => 'required',
				'payroll_element_id' => 'required',
				'dbcr_mode' => 'required',
				'status' => 'required'];
			$put_rearndedn_msg = [
				'employee_id.required' => 'Employee is a required field.',
				'payroll_element_id.required' => 'Payroll detail is a required field.',
				'dbcr_mode.required' => 'Schedule is a required field.',
				'status.required' => 'Status is a required field.'];
			$validator = Validator::make($request->all(), $put_rearndedn_rule, $put_rearndedn_msg);
			if ($validator->fails()) {
				Session::flash('put-failed', 'Failed to add input details!');
				return redirect()->back()->withErrors($validator)->withInput();
			} else {
				tbl_recur_earndedn_model::where('recur_earndedn_id', $request->recur_earndedn_id)->update([
					'employee_id' => $request->employee_id
					, 'payroll_element_id' => $request->payroll_element_id
					, 'dbcr_mode' => $request->dbcr_mode
					, 'amount' => $request->amount
					, 'date_start' => $request->date_start
					, 'date_end' => $request->date_end
					, 'status' => $request->status
					, 'payment_ctr' => $request->payment_ctr
					, 'created_by' => $this->currentUser->user_id
					, 'updated_by' => $this->currentUser->user_id,
				]);
				Session::flash('put-success', 'Recurring Earning and Deduction has been added successfully.');
			}
		}
		return redirect()->back();
	}

	public function getNonrearningsdedn() {
		$nonrearningsdedn = tbl_payroll_earndedn_model::
			where('active_flag', 'Y')
			->get();
		$payroll_mode = tbl_payroll_mode_model::
			where('active_flag', 'Y')
			->where('company_id', $this->currentCompany->company_id)
			->lists('payroll_mode', 'payroll_mode')
			->toArray();
		$employee = \App\tbl_employee_model::select(
			DB::raw("first_name || ' ' || last_name || ' (' || employee_number || ')' as employee, employee_id"))
			->where('active_flag', 'Y')
			->where('company_id', $this->currentCompany->company_id)
			->lists('employee', 'employee_id')
			->toArray();
		$payroll_element = \App\tbl_payroll_element_model::
			where('company_id', $this->currentCompany->company_id)
			->where('active_flag', 'Y')
			->lists('payroll_element_id', 'description')
			->toArray();
		return view('main.payrollmanagement.nonrearningsdedn',
			['nonrearningsdedn' => $nonrearningsdedn,
				'employee' => $employee,
				'payroll_mode' => $payroll_mode,
				'payroll_element' => $payroll_element]);
	}

	public function postNonrearningsdedn(Request $request) {
		$post_nonrearningsdedn_rule = [
			'employee_id' => 'required'];
		$post_nonrearningsdedn_msg = [
			'employee_id.required' => 'Employee number is a required field.'];
		$validator = Validator::make($request->all(), $post_nonrearningsdedn_rule, $post_nonrearningsdedn_msg);
		if ($validator->fails()) {
			Session::flash('add-failed', 'Failed to add input details!');
			return redirect()->back()->withErrors($validator)->withInput();
		} else {

			$date_from = tbl_payroll_period_model::find($request->payroll_period_id)->date_from;
			$date_to = tbl_payroll_period_model::find($request->payroll_period_id)->date_to;

			tbl_payroll_earndedn_model::create([
				'employee_id' => $request->employee_id
				, 'payroll_element_id' => $request->payroll_element_id
				, 'date_from' => $date_from
				, 'date_to' => $date_to
				, 'amount' => empty($request->amount) ? 0 : $request->amount
				, 'special_run_flag' => $request->special_run_flag
				, 'payment_ctr' => empty($request->payment_ctr) ? 0 : $request->payment_ctr
				, 'created_by' => $this->currentUser->user_id
				, 'updated_by' => $this->currentUser->user_id,
			]);
			Session::flash('add-success', 'New non recurring earnings and deductions has been added successfully.');
			return redirect()->back();
		}
	}

	public function getPayrollprocess() {
		
		$sample = DB::table('hr.tbl_payroll_process')
					->where('company_id', $this->currentCompany->company_id)
					->orderBy('created_at')
					->get();
		
		$pay_proc_rec = tbl_payroll_process_model::
			where('company_id', $this->currentCompany->company_id)
			->orderBy('created_at')
			->get();
		return view('main.payrollmanagement.payroll_process'
			, ['pay_proc_rec' => $pay_proc_rec
				, 'company' => $this->currentCompany]);
	}

	public function postPayrollprocess(Request $request) {
		if ($request->isAdd) {
			$process_type = '1';
			$post_pay_proc_rules = [
				'year' => 'required'
				, 'payroll_period_id' => 'required'
				, 'payroll_group_id' => 'required'
				, 'date_payroll' => 'required'
				, 'pay_temp_param' => 'numeric|size:1'
				, 'duplicate_entry' => 'numeric|size:0'
				, 'profile_count' => 'numeric|size:1'
			];
			$post_pay_proc_msg = [
				'year.required' => 'Year is a required field.'
				, 'payroll_period_id.required' => 'Payroll period is a required field.'
				, 'payroll_group_id.required' => 'Payroll group is a required field.'
				, 'date_payroll.required' => 'Payroll credit is a required field.'
				, 'pay_temp_param.size' => 'Payroll template parameter is not yet set for this company.'
				, 'duplicate_entry.size' => 'An existing entry with same payroll period and group is already present.'
				, 'profile_count.size' => 'Payroll profile is not yet set for the selected group.'
			];

			$request['pay_temp_param'] = db::table('hr.tbl_payroll_parameter')->where('company_id', $this->currentCompany->company_id)->count();

			$request['duplicate_entry'] = db::table('hr.tbl_payroll_process')
											->join('hr.tbl_payroll_period', function ($join) {
												$join->on('hr.tbl_payroll_process.company_id', '=', 'hr.tbl_payroll_period.company_id')
													 ->on('hr.tbl_payroll_process.date_from', '=', 'hr.tbl_payroll_period.date_from')
													 ->on('hr.tbl_payroll_process.date_to', '=', 'hr.tbl_payroll_period.date_to');
											})
											->where('hr.tbl_payroll_process.status','!=','Failed')
											->where('hr.tbl_payroll_period.payroll_period_id', $request->payroll_period_id)
											->where('hr.tbl_payroll_process.payroll_group_id', $request->payroll_group_id)
											->where('hr.tbl_payroll_process.company_id', $this->currentCompany->company_id)
											->count();

			$request['profile_count'] = db::table('hr.tbl_payroll_group')
											->join('hr.tbl_payroll_profile', 'hr.tbl_payroll_group.payroll_group_id', '=', 'hr.tbl_payroll_profile.payroll_group_id')
											->where('hr.tbl_payroll_group.payroll_group_id', $request->payroll_group_id)
											->where('hr.tbl_payroll_group.company_id', $this->currentCompany->company_id)
											->where('hr.tbl_payroll_profile.active_flag', 'Y')
											->count();

			$validator = Validator::make($request->all(), $post_pay_proc_rules, $post_pay_proc_msg);
			if ($validator->fails()) {
				Session::flash('add-failed', 'Failed to add payroll job.');
				return redirect()->back()->withErrors($validator)->withInput();
			} else {
				$month = tbl_payroll_period_model::
					where('payroll_period_id', $request->payroll_period_id)
					->first()
					->month;
				$date_from = tbl_payroll_period_model::
					where('payroll_period_id', $request->payroll_period_id)
					->first()
					->date_from;
				$date_to = tbl_payroll_period_model::
					where('payroll_period_id', $request->payroll_period_id)
					->first()
					->date_to;
				$ins_pay_proc = tbl_payroll_process_model::create(
					['company_id' => $this->currentCompany->company_id
					, 'year' => $request->year
					, 'month' => $month
					, 'payroll_group_id' => $request->payroll_group_id
					, 'process_type' => $process_type
					, 'payroll_mode' => tbl_payroll_group_model::where('payroll_group_id', $request->payroll_group_id)->first()->payroll_mode
					, 'date_from' => $date_from
					, 'date_to' => $date_to
					, 'temp_run_flag' => 'Y'
					, 'date_payroll' => date('Y-m-d', strtotime($request->date_payroll))
					, 'with_dtr_flag' => $request->with_dtr_flag
					, 'dtr_from' => null
					, 'dtr_to' => null
					, 'special_run_flag' => $request->special_run_flag == 'Y' ? 'Y' : 'N'
					, 'sss_flag' => $request->sss_flag == 'Y' ? 'Y' : 'N'
					, 'gsis_flag' => 'N'
					, 'philhealth_flag' => $request->philhealth_flag == 'Y' ? 'Y' : 'N'
					, 'pagibig_flag' => $request->pagibig_flag == 'Y' ? 'Y' : 'N'
					, 'tax_flag' => $request->tax_flag == 'Y' ? 'Y' : 'N'
					, 'loan_flag' => $request->loan_flag == 'Y' ? 'Y' : 'N'
					, 'benefits_flag' => $request->benefits_flag == 'Y' ? 'Y' : 'N'
					, 'overtime_flag' => $request->overtime_flag
					, 'post_ledger_flag' => $request->post_ledger_flag == 'Y' ? 'Y' : 'N'
					, 'auto_refund_flag' => $request->auto_refund_flag == 'Y' ? 'Y' : 'N'
					, 'approved_by' => $this->currentUser->user_id
					, 'status' => 'In Process'
					, 'created_by' => $this->currentUser->user_id
					, 'updated_by' => $this->currentUser->user_id,]
				);
				
				$job = (new PayrollJob
							($process_type
							,$ins_pay_proc->payroll_process_id
							,$this->currentCompany->company_id
							,$request->payroll_group_id
							,$request->payroll_period_id
							,$date_from
							,$date_to
							,Auth::user()->user_id)
						)
						->onConnection('database')
						->onQueue('processing');
				
				$this->dispatch($job);
				
			}
			Session::flash('add-success', 'New payroll process has been generated successfully.');
		} else {

			if (count($request->payrollprocess) > 0) {
				
				$final_rows = 0;
				$regen_rows = 0;

				foreach($request->payrollprocess as $pp) 
				{
					$pay_proc_rec = tbl_payroll_process_model::where('payroll_process_id',$pp)
										->first();
										
					$pr_period = tbl_payroll_period_model::where('company_id',$this->currentCompany->company_id)
									->where('payroll_mode',$pay_proc_rec->payroll_mode)
									->where('date_from',$pay_proc_rec->date_from)
									->where('date_to',$pay_proc_rec->date_to)
									->first()
									->payroll_period_id;
					
					if(trim($pay_proc_rec->status) == 'Final') {
						$final_rows++;
					} else {
						$deleted = DB::delete("delete from hr.tbl_payroll where payroll_process_id = '$pp' and final_flag='N'");
						$deleted = DB::delete("delete from hr.tbl_payroll_process_emp where payroll_process_id = '$pp'");
						
						$job = (new PayrollJob
							($pay_proc_rec->process_type
							,$pay_proc_rec->payroll_process_id
							,$this->currentCompany->company_id
							,$pay_proc_rec->payroll_group_id
							,$pr_period
							,$pay_proc_rec->date_from
							,$pay_proc_rec->date_to
							,Auth::user()->user_id)
						)
						->onConnection('database')
						->onQueue('processing');
				
						$this->dispatch($job);
						
						tbl_payroll_process_model::find($pp)->update(
							['status' => 'In Process']
						);
						
						$regen_rows++;
					}
				}
				
				if($regen_rows > 0) Session::flash('add-success', $regen_rows.' record(s) selected has been regenerated.');
				
				if($final_rows > 0) Session::flash('add-warning','Cannot regenerate '.$final_rows.' record(s) on selected because it is marked as final');

			} else {
				Session::flash('add-warning', 'No selected records found! Nothing to regenerate.');
			}
		}
		return redirect()->back();
	}
	
	public function deletePayrollprocess(Request $request)
	{
		if (count($request->payrollprocess) > 0) {
			
			$del_rows = 0;
			$final_rows = 0;
			
			foreach($request->payrollprocess as $pp)
			{
				$pay_proc_rec = tbl_payroll_process_model::where('payroll_process_id',$pp)
										->first();
										
				if(trim($pay_proc_rec->status) == 'Final') {
						$final_rows++;
				} else {
					$deleted = DB::delete("delete from hr.tbl_payroll where payroll_process_id = '$pp' and final_flag='N'");
					$deleted = DB::delete("delete from hr.tbl_payroll_process_emp where payroll_process_id = '$pp'");
					$deleted = DB::delete("delete from hr.tbl_payroll_process where payroll_process_id = '$pp' and status!='Final'");
				
					$del_rows = $del_rows + $deleted;
				}
			}
			
			if($del_rows > 0) Session::flash('del-success', $del_rows.' record(s) selected has been deleted successfully.');
			
			if($final_rows > 0) Session::flash('del-warning','Cannot delete '.$final_rows.' record(s) on selected because it is marked as final.');
			
			if($del_rows == 0 && $final_rows == 0) Session::flash('del-warning', 'No selected records found! Nothing to delete.');
			
		} else {
			Session::flash('del-warning', 'No selected records found! Nothing to delete.');
		}
		
		return redirect()->back();
	}

	public function putPayrollprocess(Request $request)
	{
		if (count($request->payrollprocess) > 0) {
			
			$final_rows = 0;
			
			foreach($request->payrollprocess as $pp)
			{
				$updated = DB::table('hr.tbl_payroll_process')
							->where('payroll_process_id',$pp)
							->update(['status' => 'Final']);
							
				$deleted = DB::delete("delete from hr.tbl_payroll_process_emp where payroll_process_id = '$pp'");
							
				DB::table('hr.tbl_payroll')
					->where('payroll_process_id',$pp)
					->update(['final_flag' => 'Y']);
				
				$final_rows = $final_rows + $updated;
			}
			
			Session::flash('add-success', $final_rows.' record(s) selected has been marked as final.');
		} else {
			Session::flash('add-warning', 'No selected records found! Nothing to finalized.');
		}
		
		return redirect()->back();
	}
	
	public function getPayrollprocessdetails($payroll_process_id) 
	{
		$status = db::table('hr.tbl_payroll_process')
					->where('payroll_process_id', $payroll_process_id)
					->select('status')
					->get()[0]
					->status;
					
		if (trim($status) != 'Completed' && trim($status) != 'Final' && trim($status) != 'Failed' ) {
			
			Session::flash('add-warning', 'Unable to display details because the job is still in progress.');
			return redirect()->back();
			
		} else {
			$payroll_process_det = db::select(
				db::raw("select pay.payroll_process_id
				   , emp.employee_id
				   , emp.first_name || ' ' || emp.last_name as employee_name
				   , mv.basic_amt
				   , sum(case when pay.entry_type = 'CR' then pay.entry_amt else 0 end) gross
				   , max(pay.daily_rate_amt) daily_rate
				   , sum(case when pay.entry_type = 'DB' then pay.entry_amt else 0 end) as deduction
				   , (sum(case when pay.entry_type = 'CR' then pay.entry_amt else 0 end) - sum(case when pay.entry_type = 'DB' then pay.entry_amt else 0 end)) as net_pay
				   from hr.tbl_payroll pay
				   join hr.tbl_employee emp
				   on emp.employee_id = pay.employee_id
				   join hr.tbl_movement mv
				   on mv.employee_id = emp.employee_id
				   and mv.active_flag ='Y'
				   where pay.payroll_process_id = '" . $payroll_process_id . "'
				   and pay.company_id = '" . $this->currentCompany->company_id . "'
				   group by emp.employee_id,
				   emp.first_name,
				   emp.last_name,
				   mv.basic_amt,
				   pay.payroll_process_id")
			);
			return view('main.payrollmanagement.payroll_process_details'
				, ['pay_proc_det' => $payroll_process_det
					, 'company_id' => $this->currentCompany->company_id]);
		}
	}

	public function getPayrollprocessempdetails($payroll_process_id, $employee_id) {
		$emp_details = db::select(
			db::raw("select  emp.first_name || ' ' || emp.last_name as employee_name
              , emp.employee_number
              , post.description position_name
              , bu.business_unit_name
              , mv.basic_amt
              from hr.tbl_employee emp
              join hr.tbl_movement mv
              on mv.employee_id = emp.employee_id
              and mv.active_flag ='Y'
              join hr.tbl_position post
              on post.position_id = emp.position_id
              join hr.tbl_business_unit bu
              on bu.business_unit_id = post.business_unit_id
              where emp.employee_id = '" . $employee_id . "'
              and emp.company_id = '" . $this->currentCompany->company_id . "'"
			))[0];

		$payslip_det = db::select(
			db::raw("select  pay.payroll_process_id
              , pay.date_payroll
              , pay.date_from
              , pay.date_to
              , elem.description element_name
              , pay.entry_type
              , pay.entry_amt
              from hr.tbl_payroll			pay
              join hr.tbl_payroll_element	elem	on	elem.payroll_element_id	= pay.payroll_element_id
													and elem.company_id			= pay.company_id
              join hr.tbl_employee			emp		on	emp.employee_id			= pay.employee_id
              join hr.tbl_movement			mv		on	mv.employee_id			= emp.employee_id
													and	mv.active_flag			= 'Y'
              where	pay.payroll_process_id	= '" . $payroll_process_id . "'
              and	pay.company_id			= '" . $this->currentCompany->company_id . "'
              and	emp.employee_id			= '" . $employee_id . "'"
			));

		return view('main.payrollmanagement.payroll_process_emp_details'
			, ['company_id' => $this->currentCompany->company_id
				, 'payroll_process_id' => $payroll_process_id
				, 'employee' => $emp_details
				, 'payslip' => $payslip_det]);
	}

	public function getReport()
	{
		$reportsList = db::table('hr.tbl_report')
			->whereIn('company_id',['0',$this->currentCompany->company_id])
			->get();

		$groupReports = array();

		foreach ($reportsList as $key => $value) {
			$groupReports[$value->report_type][$key] = $value;
		}

		return view('main.payrollmanagement.payroll_process_report',['reports' => $groupReports]);
	}

}
