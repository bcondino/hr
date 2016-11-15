<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class PayrollJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
	
	protected $process_type, $payroll_process_id, $company_id, $payroll_group_id, $payroll_period_id, $date_from, $date_to, $user_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($process_type, $payroll_process_id, $company_id, $payroll_group_id, $payroll_period_id, $date_from, $date_to, $user_id)
    {
        $this->process_type = $process_type;
        $this->payroll_process_id = $payroll_process_id;
		$this->company_id = $company_id;
		$this->payroll_group_id = $payroll_group_id;
		$this->payroll_period_id = $payroll_period_id;
		$this->date_from = $date_from;
		$this->date_to = $date_to;
		$this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		set_time_limit(0);
		ini_set('memory_limit','1056M');
		
		echo $this->date_from;
		
        //SQL 1
		$pay_proc_rec = $this->sel_payProc($this->payroll_process_id, $this->company_id, $this->payroll_group_id);
			
		/* TODO: Transfer this section on the part of creating entry on tbl_payroll_process */
        $emp_rec = db::select(
            db::raw("select emp.employee_id
					from hr.tbl_employee emp
					join hr.tbl_movement mv
					on mv.employee_id = emp.employee_id
					and mv.active_flag = 'Y'
					where emp.payroll_group_id = '$this->payroll_group_id'
					and emp.company_id = '$this->company_id'
					and emp.date_hired <= '$this->date_from'
					and emp.active_flag = 'Y'")
        );
		
		if ($this->process_type == '1') {
			foreach ($emp_rec as $emp) 
			{
				db::table('hr.tbl_payroll_process_emp')->insert(
					['payroll_process_id' => $this->payroll_process_id
					,'employee_id' => $emp->employee_id]
				);
			}
        } 
		 else {
		//	if($process_type == '0')
        }
		/* TODO: End of section */
		
		//select parameter values
		$param_rec = $this->sel_payParam($this->company_id);
		
		foreach($pay_proc_rec as $process)
		{
			//SQL2
			$pay_prof_rec = $this->sel_payProf($this->payroll_process_id, $this->payroll_period_id, $this->payroll_group_id, $this->company_id);
			$prof_count = count($pay_prof_rec);
			$i = 0;
			
			foreach($pay_prof_rec as $profile)
			{
				$basic_da = $this->init_Basic($profile->salary_type, $profile->basic_amt, $process->hrs_day, $process->days_mo);
				$basic = 0;
				
				if(!empty($profile->tax_code)) {
					if ($profile->salary_type == 'HR') {
						$basic = round($basic_da * $process->work_days, 4);
					} else if ($profile->salary_type == 'DA') {
						$basic = round($profile->basic_amt * $process->work_days, 4);
					} else if ($profile->salary_type == 'MO') {
						$basic = round($profile->basic_amt / $profile->no_of_payment, 4);
					}
				}
				
				if($profile->basic_amt > 0) {
					$msg_basic = $this->add_payroll	($this->payroll_process_id
										,$profile->employee_id
										,$process->company_id
										,$profile->business_unit_id
										,$profile->tax_code
										,$profile->tax_mode
										,$process->payroll_group_id
										,$profile->payroll_mode
										,$process->payroll_period
										,$profile->basic_amt
										,$profile->ecola_amt
										,$profile->allowance_amt
										,0
										,0
										,0
										,0
										,$process->year
										,$process->month
										,$process->date_from
										,$process->date_to
										,$process->date_payroll
										,0
										,0
										,'CR'
										,$profile->payroll_type_id_basic
										,$basic
										,$process->special_run_flag
										,null
										,0
										,$basic_da
										,$process->days_mo
										,null // TODO: will change this if tbl_wage_order will be updated
										); 
				}
				
				$this->add_earnings($process, $profile->employee_id);
				
				$this->add_recur_earnings($process, $profile->employee_id);
				
				$this->add_deductions($process, $param_rec, $profile->employee_id);
				
				$this->add_recur_deductions($process, $param_rec, $profile->employee_id);
				
				if($process->sss_flag == 'Y'){
					$this->add_sss($process, $profile->salary_type, $profile->employee_id);
				}
				
				if($process->pagibig_flag == 'Y'){
					$this->add_hdmf($process, $profile->salary_type, $profile->employee_id);
				}
				
				if($process->philhealth_flag == 'Y') {
					$this->add_philhealth($process, $profile->salary_type, $profile->employee_id);
				}
				
				if($process->tax_flag == 'Y') {
					$this->add_tax($process, $profile, $param_rec, $profile->employee_id);
				}
				
				// TODO: Other more processes are executed here (eg. loans, recurring deductions with priority, net take home pay, sequences, etc.)

				$i++;

				$progress = round( $i/$prof_count, 2 ) * 100;

				$this->updateStatusPayProc($this->payroll_process_id, $progress.'%');
				
			}
		}
		
		$this->updateStatusPayProc($this->payroll_process_id, 'Completed');
		
    }
	
	/**
	 * Handle a job failure
	 *
	 * @return void
	 */
	public function failed()
	{
		// Delete entries created on tbl_payroll if there is one
		DB::table('hr.tbl_payroll')->where('payroll_process_id', $this->payroll_process_id)->delete();
		// Set payroll process to failed
		$this->updateStatusPayProc($this->payroll_process_id, 'Failed');
	}
	
	//SQL1
    public function sel_payProc	($payroll_process_id
								,$company_id
								,$payroll_group_id)
    {
        $proc_rec = db::select(
            db::raw("select proc.company_id
				,proc.payroll_process_id
				,proc.year
				,proc.month
				,proc.payroll_group_id
				,proc.payroll_mode
				,proc.process_type
				,proc.date_from
				,proc.date_to
				,proc.date_payroll
				,proc.with_dtr_flag
				,proc.dtr_from
				,proc.dtr_to
				,proc.special_run_flag
				,proc.sss_flag
				,proc.gsis_flag
				,proc.philhealth_flag
				,proc.pagibig_flag
				,proc.tax_flag
				,proc.loan_flag
				,proc.benefits_flag
				,proc.overtime_flag
				,proc.post_ledger_flag
				,proc.auto_refund_flag
				,proc.company_id
				,proc.created_at
				,proc.created_by
				,proc.approved_by
				,proc.updated_at
				,proc.status
				,md.no_of_payment
				,md.tax_mode_eom
				,per.dtr_mo_from
				,per.dtr_mo_to
				,per.payroll_period
				,per.work_days
				,per.hrs_day
				,per.hrs_pay
				,per.days_mo
				,per.days_yr
			from	hr.tbl_payroll_process	as proc
			join	hr.tbl_payroll_period	as per	on	per.date_from		= proc.date_from
													and	per.date_to			= proc.date_to
													and per.payroll_mode	= proc.payroll_mode
													and	per.company_id		= proc.company_id
			join	hr.tbl_payroll_mode		as md	on	md.payroll_mode		= proc.payroll_mode
													and	md.company_id		= proc.company_id
			where	proc.payroll_process_id	= '$payroll_process_id'
			and		proc.company_id			= '$company_id'
			and		proc.payroll_group_id	= '$payroll_group_id'
			and		proc.status				= 'In Process'")
        );

        return $proc_rec;
    }
	
	//select parameter values
    public function sel_payParam($company_id)
    {
        $pay_param_rec = db::select(
            db::raw("select	payroll_parameter_id
										,exempted_amt
										,idx_flag
										,net_takehome_amt
										,tax_method
										,bonus_amt
										,ave_ot_amt
										,spl_tax_method
										,annualize_income_mo
										,refund_mode
										,mwe_flag
										,benefits_flag
										,paid_holiday_flag
										,ded_late_flag
										,ded_utime_flag
										,ded_absent_flag
										,min_ded_late
										,frequency
										,with_dtr_flag
										,sss_sched
										,gsis_sched
										,pagibig_sched
										,philhealth_sched
										,company_id
										,updated_at
								FROM	hr.tbl_payroll_parameter
								WHERE	company_id	= '$company_id'"
            ))[0];

        return $pay_param_rec;
    }
	
	//SQL2
    public function sel_payProf	($pay_proc_id
								,$pay_period_id
								,$pay_grp_id
								,$company_id)
    {
        $pay_prof_rec = db::select(
            db::raw("select emp.employee_id
				,prof.company_id
				,pem.payroll_process_id
				,prof.payroll_group_id
				,per.payroll_period
				,grp.payroll_mode
				,prof.tax_fix_amt
				,prof.add_tax_amt
				,prof.sub_filing_flag
				,prof.ded_sss_flag
				,prof.ded_gsis_flag
				,prof.ded_pagibig_flag
				,prof.pagibig_fix_amt
				,prof.ded_philhealth_flag
				,prof.ded_sss_basic_flag
				,prof.ded_gsis_basic_flag
				,prof.ded_pagibig_basic_flag
				,prof.ded_philhealth_basic_flag
				,prof.ded_sss_sb_amt
				,prof.ded_gsis_sb_amt
				,prof.ded_pagibig_sb_amt
				,prof.ded_philhealth_sb_amt
				,prof.status
				,mv.effective_date
				,mv.employee_status
				,post.class_id
				,post.business_unit_id
				,post.position_id
				,prof.company_id
				,mv.tax_code
				,mv.salary_type
				,mv.payroll_type_id_basic
				,mv.basic_amt
				,mv.ecola_amt
				,mv.allowance_amt
				,md.no_of_payment
				,md.tax_mode
				,per.work_days
				,per.hrs_day
				,per.days_mo
				,proc.year
				,proc.month
				,proc.special_run_flag
				,proc.date_payroll
				,per.date_from
				,per.date_to
			from		hr.tbl_payroll_profile		as prof
			join		hr.tbl_payroll_group		as grp	on	grp.payroll_group_id	= prof.payroll_group_id
															and	grp.company_id			= prof.company_id
			join		hr.tbl_employee				as emp	on	emp.payroll_group_id	= prof.payroll_group_id
															and	emp.company_id			= prof.company_id
			join		hr.tbl_payroll_process_emp	as pem	on	pem.employee_id			= emp.employee_id
			left join	hr.tbl_position				as post	on	post.position_id		= emp.position_id
			join		hr.view_movement			as mv	on	mv.employee_id			= emp.employee_id
			join		hr.tbl_payroll_mode			as md	on	md.payroll_mode			= grp.payroll_mode
															and	md.company_id			= prof.company_id
			join		hr.tbl_payroll_process		as proc	on	proc.payroll_process_id	= pem.payroll_process_id
			join		hr.tbl_payroll_period		as per	on	per.payroll_mode		= prof.payroll_mode
															and	per.company_id			= prof.company_id
			where	pem.payroll_process_id	= '$pay_proc_id'
			and		prof.payroll_group_id	= '$pay_grp_id'
			and		prof.status				= 0
			and		per.payroll_period_id	= '$pay_period_id'
			and		prof.company_id			= '$company_id'")
        );

        return $pay_prof_rec;

    }
	
	//basic amount computation
    public function init_Basic	($salary_type
								,$basic_amt
								,$hrs_day
								,$days_mo)
    {
		$basic = 0;

		if ($salary_type == 'HR') {
			$basic = round($basic_amt * $hrs_day, 2);
		} else if ($salary_type == 'DA') {
			$basic = $basic_amt;
		} else if ($salary_type == 'MO') {
			$basic = round($basic_amt / $days_mo, 2);
		}

        return $basic;
    }
	
	//insert into tbl_payroll
    public function add_payroll	($payroll_process_id
								,$employee_id
								,$company_id
								,$business_unit_id
								,$tax_code
								,$tax_mode
								,$payroll_group_id
								,$payroll_mode
								,$payroll_period
								,$basic_amt
								,$ecola_amt
								,$allowance_amt
								,$hrs_work
								,$hrs_late
								,$hrs_undertime
								,$hrs_absent
								,$year_trans
								,$month_trans
								,$date_from
								,$date_to
								,$date_payroll
								,$sequence_no
								,$group_sequence_no
								,$entry_type
								,$payroll_element_id
								,$entry_amt
								,$special_run_flag
								,$tran_ref_id
								,$payment_ctr
								,$daily_rate_amt
								,$days_mo
								,$min_wage_amt
								)
	{
        db::table('hr.tbl_payroll')->insert(
			['payroll_process_id' => $payroll_process_id
            , 'employee_id' => $employee_id
            , 'company_id' => $company_id
            , 'business_unit_id' => $business_unit_id
            , 'tax_code' => $tax_code
            , 'tax_mode' => $tax_mode
            , 'payroll_group_id' => $payroll_group_id
            , 'payroll_mode' => $payroll_mode
            , 'payroll_period' => $payroll_period
            , 'basic_amt' => $basic_amt
            , 'ecola_amt' => $ecola_amt
            , 'allowance_amt' => $allowance_amt
            , 'hrs_work' => $hrs_work
            , 'hrs_late' => $hrs_late
            , 'hrs_undertime' => $hrs_undertime
            , 'hrs_absent' => $hrs_absent
            , 'year_trans' => $year_trans
            , 'month_trans' => $month_trans
            , 'date_from' => $date_from
            , 'date_to' => $date_to
            , 'date_payroll' => $date_payroll
            , 'sequence_no' => $sequence_no
            , 'group_sequence_no' => $group_sequence_no
            , 'entry_type' => $entry_type
            , 'payroll_element_id' => $payroll_element_id
            , 'entry_amt' => $entry_amt
            , 'special_run_flag' => $special_run_flag
            , 'tran_ref_id' => $tran_ref_id
            , 'payment_ctr' => $payment_ctr
            , 'daily_rate_amt' => $daily_rate_amt
            , 'days_mo' => $days_mo
            , 'min_wage_amt' =>$min_wage_amt
            , 'created_by' => $this->user_id
            , 'active_flag' => 'Y'
            , 'final_flag' => 'N'
			]
		);
    }
	
	public function sel_earndedn($company_id
								,$entry_type
								,$payroll_process_id
								,$employee_id
								,$dt_from
								,$dt_to
								,$pay_grp_id
								,$special_run_flag)
	{
        //SQL3 Earnings/Deduction
        $earn_rec = db::select(
            db::raw("select earn.payroll_earndedn_id
			,earn.employee_id
			,pay.business_unit_id
			,pay.company_id
			,grp.payroll_group_id
			,pay.tax_code
			,md.tax_mode
			,md.payroll_mode
			,mv.salary_type
			,pay.basic_amt
			,pay.ecola_amt
			,pay.allowance_amt
			,earn.payroll_element_id
			,earn.amount
			,earn.payment_ctr
			,pay.earning_amt
			,pay.deduction_amt
			,pay.payroll_process_id
			,pay.payroll_period
			,pay.year_trans as year
			,pay.month_trans as month
			,'$dt_from' as date_from
			, '$dt_to' as date_to
			,(emp.last_name || ', ' || emp.first_name || ' ' || LEFT(emp.middle_name, 1) || '. (' || emp.employee_number ||')') AS employee_name
			,elem.description
			,wage.per_day_amt
		from hr.tbl_payroll_earndedn earn
		inner join (
		SELECT	employee_id
			,	company_id
			,	business_unit_id
			,	payroll_mode
			,	date_from
			,	date_to
			,	SUM(hrs_late) AS late
			,	SUM(hrs_undertime) AS utime
			,	SUM(hrs_absent) AS absent
			,	SUM(CASE WHEN entry_type='CR' THEN entry_amt ELSE 0 END) AS earning_amt
			,	SUM(CASE WHEN entry_type='DB' THEN entry_amt ELSE 0 END) AS deduction_amt
			,	(SUM(CASE WHEN entry_type='CR' THEN entry_amt ELSE 0 END) - SUM(CASE WHEN entry_type='DB' THEN entry_amt ELSE 0 END)) as total
			,	tax_code
			,	tax_mode
			,	payroll_period
			,	basic_amt
			,	ecola_amt
			,	allowance_amt
			,	payroll_process_id
			, 	year_trans
			,	month_trans
			FROM	hr.tbl_payroll
			WHERE	payroll_process_id = '$payroll_process_id'
			AND     employee_id        = '$employee_id'
			GROUP BY 	employee_id
					,	company_id
					,	business_unit_id
					,	payroll_mode
					,	date_from
					,	date_to
					,	tax_code
					,	tax_mode
					,	payroll_period
					,	basic_amt
					,	ecola_amt
					,	allowance_amt
					,	payroll_process_id
					, 	year_trans
					, month_trans
		) pay
		on earn.employee_id = pay.employee_id
		join hr.tbl_payroll_element elem
		on elem.payroll_element_id = earn.payroll_element_id
		and pay.company_id = elem.company_id
		join hr.tbl_employee emp
		on earn.employee_id = emp.employee_id
		join hr.tbl_payroll_group grp
		on emp.payroll_group_id = grp.payroll_group_id
		join hr.tbl_payroll_profile prof
		on grp.payroll_group_id = prof.payroll_group_id
		join hr.tbl_payroll_mode md
		on prof.payroll_mode = md.payroll_mode
		and pay.company_id = md.company_id
		join hr.tbl_movement mv
		on mv.employee_id = emp.employee_id
		and mv.active_flag = 'Y'
		join hr.tbl_business_unit unit
		on unit.business_unit_id = pay.business_unit_id
		left join hr.tbl_wage_order wage
		on wage.region = unit.region
		and pay.company_id = wage.company_id
		where pay.company_id = '$company_id'
		and earn.date_from = '$dt_from'
		and earn.date_to = '$dt_to'
		and grp.payroll_group_id = '$pay_grp_id'
		and earn.special_run_flag = '$special_run_flag'
		and elem.entry_type = '$entry_type'")
        );

        return $earn_rec;

    }
	
	public function sel_recur	($company_id
								,$entry_type
								,$payroll_process_id
								,$employee_id
								,$date_from
								,$date_to
								,$payroll_group_id)
	{
        //SQL3 Recurring Earnings/Deductions
        $recur_earndedn_rec = db::select(
            db::raw("select rec.recur_earndedn_id
					,rec.employee_id
					,pay.business_unit_id
					,pay.tax_code
					,pay.tax_mode
					,pay.payroll_mode
					,mv.salary_type
					,pay.basic_amt
					,pay.ecola_amt
					,pay.allowance_amt
					,rec.payroll_element_id
					,rec.amount
					,rec.payment_ctr
					,pay.earning_amt
					,pay.deduction_amt
					,rec.last_name || ',' || rec.first_name || ' ' || left(rec.middle_name, 1) || '.' || rec.employee_number as emp_name
					,rec.description as payroll_typ_dscp
					,wage.per_day_amt
					,$company_id as company_id
					,$payroll_group_id as payroll_group_id
				from hr.view_recur_earndedn_pay rec
				inner join	(select	employee_id
								,company_id
								,business_unit_id
								,payroll_mode
								,payroll_group_id
								,date_from
								,date_to
								,sum(case when entry_type ='CR' then entry_amt else 0 end) as earning_amt
								,sum(case when entry_type ='DB' then entry_amt else 0 end) as deduction_amt
								,(sum(case when entry_type ='CR' then entry_amt else 0 end) - sum(case when entry_type = 'DB' then entry_amt else 0 end)) as total
								,tax_code
								,tax_mode
								,payroll_period
								,basic_amt
								,ecola_amt
								,allowance_amt
							from	hr.tbl_payroll
							where	payroll_process_id = '$payroll_process_id'
							and     employee_id        = '$employee_id'
							group by employee_id
								,company_id
								,business_unit_id
								,payroll_mode
								,payroll_group_id
								,date_from
								,date_to
								,tax_code
								,tax_mode
								,payroll_period
								,basic_amt
								,ecola_amt
								,allowance_amt)	as pay
				on rec.employee_id		= pay.employee_id
				inner join hr.view_movement as mv
				on rec.employee_id = mv.employee_id
				join hr.tbl_employee emp
				on rec.employee_id = emp.employee_id
				join hr.tbl_payroll_group grp
				on emp.payroll_group_id = grp.payroll_group_id
				join hr.tbl_business_unit unit
				on unit.business_unit_id = pay.business_unit_id
				left join hr.tbl_wage_order wage
				on wage.region = unit.region
				and pay.company_id = wage.company_id
				where pay.company_id	= '$company_id'
				and rec.date_start <= '$date_from'
				and rec.date_end >= '$date_to'
				and pay.payroll_group_id = '$payroll_group_id'
				and rec.status = 'Y'
				and rec.amount > 0
				and rec.entry_type = '$entry_type'
				and (rec.dbcr_mode = pay.payroll_period or rec.dbcr_mode = 3)
				and rec.priority_no	= 0
				order by rec.employee_id, rec.recur_earndedn_id")
        );

        return $recur_earndedn_rec;
    }
	
	public function add_earnings($process, $employee_id)
	{
		$earn_rec = $this->sel_earndedn	($process->company_id
										,'CR'
										,$process->payroll_process_id
										,$employee_id
										,$process->date_from
										,$process->date_to
										,$process->payroll_group_id
										,$process->special_run_flag);
		
		foreach($earn_rec as $earn) 
		{
			$basic = $this->init_Basic($earn->salary_type, $earn->basic_amt, $process->hrs_day, $process->days_mo);
			
			$msg_earn = $this->add_payroll($process->payroll_process_id
								,$earn->employee_id
								,$process->company_id
								,$earn->business_unit_id
								,$earn->tax_code
								,$earn->tax_mode
								,$process->payroll_group_id
								,$earn->payroll_mode
								,$process->payroll_period
								,$earn->basic_amt
								,$earn->ecola_amt
								,$earn->allowance_amt
								,0
								,0
								,0
								,0
								,$process->year
								,$process->month
								,$process->date_from
								,$process->date_to
								,$process->date_payroll
								,0
								,0
								,'CR'
								,$earn->payroll_element_id
								,$earn->amount
								,$process->special_run_flag
								,$earn->recur_earndedn_id
								,$earn->payment_ctr
								,$basic
								,$process->days_mo
								,null); // TODO: will change this if tbl_wage_order will be updated
		}	
	}
	
	public function add_recur_earnings($process, $employee_id)
	{
		$recur_earn_rec = $this->sel_recur	($process->company_id
											,'CR'
											,$process->payroll_process_id
											,$employee_id
											,$process->date_from
											,$process->date_to
											,$process->payroll_group_id);
											
		foreach($recur_earn_rec as $recur_earn)
		{
			$basic = $this->init_Basic($recur_earn->salary_type, $recur_earn->basic_amt, $process->hrs_day, $process->days_mo);
			
			$msg_recur_earn = $this->add_payroll($process->payroll_process_id
								,$recur_earn->employee_id
								,$process->company_id
								,$recur_earn->business_unit_id
								,$recur_earn->tax_code
								,$recur_earn->tax_mode
								,$process->payroll_group_id
								,$recur_earn->payroll_mode
								,$process->payroll_period
								,$recur_earn->basic_amt
								,$recur_earn->ecola_amt
								,$recur_earn->allowance_amt
								,0
								,0
								,0
								,0
								,$process->year
								,$process->month
								,$process->date_from
								,$process->date_to
								,$process->date_payroll
								,0
								,0
								,'CR'
								,$recur_earn->payroll_element_id
								,$recur_earn->amount
								,$process->special_run_flag
								,$recur_earn->recur_earndedn_id
								,$recur_earn->payment_ctr
								,$basic
								,$process->days_mo
								,null); // TODO: will change this if tbl_wage_order will be updated
		}
	}
	
	public function add_deductions($process, $param_rec, $employee_id)
	{
		$dedn_rec = $this->sel_earndedn	($process->company_id
										,'DB'
										,$process->payroll_process_id
										,$employee_id
										,$process->date_from
										,$process->date_to
										,$process->payroll_group_id
										,$process->special_run_flag);
		
		$strEmpId     = null;
		$dblRunAmount = 0;
										
		foreach($dedn_rec as $dedn)
		{
			$blnIsNegative = null;
			
			$basic = $this->init_Basic($dedn->salary_type, $dedn->basic_amt, $process->hrs_day, $process->days_mo);
			
			if ((empty($strEmpId)) || ($strEmpId != $dedn->employee_id)) {
				$strEmpId     = $dedn->employee_id;
				$dblRunAmount = 0;
			}
			
			$dblRunAmount += $dedn->amount;
			
			if ($param_rec->idx_flag == 'N') {
				$blnIsNegative = (($dedn->earning_amt - ($dedn->deduction_amt + $dblRunAmount)) / $dedn->earning_amt) < ($param_rec->net_takehome_amt / 100) ? true : false;
			} else {
				$blnIsNegative = ($dedn->earning_amt - ($dedn->deduction_amt + $dblRunAmount)) < $param_rec->net_takehome_amt ? true : false;
			}
			
			if ($blnIsNegative) {

				$dblRunAmount -= $dedn->amount;

				DB::table('hr.tbl_uncollected')->insert(
					['employee_id' => $dedn->employee_id
					,'payroll_process_id' => $dedn->payroll_process_id
					,'date_from' => $date_from
					,'date_to' => $date_to
					,'loan_id' => $dedn->payroll_earndedn_id
					,'payroll_element_id' => $dedn->payroll_element_id
					,'uncollected_amount' => $dedn->amount,
					]
				);
				
			} else {
				$msg_dedn = $this->add_payroll($process->payroll_process_id
								,$dedn->employee_id
								,$process->company_id
								,$dedn->business_unit_id
								,$dedn->tax_code
								,$dedn->tax_mode
								,$process->payroll_group_id
								,$dedn->payroll_mode
								,$process->payroll_period
								,$dedn->basic_amt
								,$dedn->ecola_amt
								,$dedn->allowance_amt
								,0
								,0
								,0
								,0
								,$process->year
								,$process->month
								,$process->date_from
								,$process->date_to
								,$process->date_payroll
								,0
								,0
								,'DB'
								,$dedn->payroll_element_id
								,$dedn->entry_amt
								,$process->special_run_flag
								,$dedn->payroll_earndedn_id
								,$dedn->payment_ctr
								,$basic
								,$process->days_mo
								,null); // TODO: will change this if tbl_wage_order will be updated
			}
			
		}
	}
	
	public function add_recur_deductions($process, $param_rec, $employee_id)
	{
		$recur_dedn_rec = $this->sel_recur	($process->company_id
											,'DB'
											,$process->payroll_process_id
											,$employee_id
											,$process->date_from
											,$process->date_to
											,$process->payroll_group_id);
											
		$strEmpId     = null;
		$dblRunAmount = 0;
		
		foreach($recur_dedn_rec as $recur_dedn)
		{
			$blnIsNegative = null;
			
			$basic = $this->init_Basic($recur_dedn->salary_type, $recur_dedn->basic_amt, $process->hrs_day, $process->days_mo);
			
			if ((empty($strEmpId)) || ($strEmpId != $recur_dedn->employee_id)) {
				$strEmpId     = $recur_dedn->employee_id;
				$dblRunAmount = 0;
			}
			
			$dblRunAmount += $recur_dedn->amount;

			if ($param_rec->idx_flag == 'N') {
				$blnIsNegative = (($recur_dedn->earning_amt - ($recur_dedn->deduction_amt + $dblRunAmount)) / $recur_dedn->earning_amt) < ($param_rec->net_takehome_amt / 100) ? true : false;
			} else {
				$blnIsNegative = ($recur_dedn->earning_amt - ($recur_dedn->deduction_amt + $dblRunAmount)) < $param_rec->net_takehome_amt ? true : false;
			}
			
			if ($blnIsNegative) {
				
				$dblRunAmount -= $recur_dedn->amount;
				
				DB::table('hr.tbl_uncollected')->insert(
					['employee_id' => $recur_dedn->employee_id
						, 'payroll_process_id' => $recur_dedn->payroll_process_id
						, 'date_from' => $date_from
						, 'date_to' => $date_to
						, 'loan_id' => $recur_dedn->payroll_earndedn_id
						, 'payroll_element_id' => $recur_dedn->payroll_element_id
						, 'uncollected_amount' => $recur_dedn->amount,
					]
				);
			} else {
				$msg_recur_dedn = $this->add_payroll($process->payroll_process_id
								,$recur_dedn->employee_id
								,$process->company_id
								,$recur_dedn->business_unit_id
								,$recur_dedn->tax_code
								,$recur_dedn->tax_mode
								,$process->payroll_group_id
								,$recur_dedn->payroll_mode
								,$process->payroll_period
								,$recur_dedn->basic_amt
								,$recur_dedn->ecola_amt
								,$recur_dedn->allowance_amt
								,0
								,0
								,0
								,0
								,$process->year
								,$process->month
								,$process->date_from
								,$process->date_to
								,$process->date_payroll
								,0
								,0
								,'DB'
								,$recur_dedn->payroll_element_id
								,$recur_dedn->amount
								,$process->special_run_flag
								,$recur_dedn->recur_earndedn_id
								,$recur_dedn->payment_ctr
								,$basic
								,$process->days_mo
								,null); // TODO: will change this if tbl_wage_order will be updated
			}
		}
	}
	
	public function add_sss($process, $salary_type, $employee_id)
	{
		$sss = db::select(
            db::raw("select A.employee_id
					,(A.last_name || ', ' || A.first_name || ' ' || LEFT(A.middle_name, 1) || '.') AS emp_name
					,a.payroll_group_id
					,A.company_id
					,A.business_unit_id
					,A.tax_code
					,A.tax_mode
					,A.payroll_mode
					,A.salary_type
					,A.basic_amt
					,A.ecola_amt
					,A.allowance_amt
					,A.ded_sss_sb_amt
					,A.ded_philhealth_sb_amt
					,A.ded_pagibig_sb_amt
					,A.ded_sss_basic_flag
					,A.ded_sss_flag
					,A.sss_total as total
					,B.ee_sss_cont as ee_cont
					,B.er_sss_cont as er_cont
					,B.er_ec_cont
					,A.sss_ee as ee
					,A.sss_er as er
					,A.sss_ec as ec
					,C.ee_sss_cont as ee_cont_bs
					,C.er_sss_cont as er_cont_bs
					,C.er_ec_cont as er_ec_bs
					,coalesce(D.ee_sss_cont, 0) as ee_cont_sb
					,coalesce(D.er_sss_cont, 0) as er_cont_sb
					,coalesce(D.er_ec_cont, 0) as er_ec_sb
					FROM hr.view_govt_dedn A
					LEFT JOIN hr.tbl_sss B on A.sss_total >= B.range_from
						AND	A.sss_total	< B.range_to
						AND	A.company_id = B.company_id
					LEFT JOIN hr.tbl_sss C on A.basic_amt >= C.range_from
						AND	A.basic_amt < C.range_to
						AND	A.company_id = C.company_id
					LEFT JOIN hr.tbl_sss D on A.ded_sss_sb_amt >= D.range_from
						AND	A.ded_sss_sb_amt < D.range_to
						AND	A.company_id = D.company_id
					INNER JOIN (SELECT	employee_id, MAX(min_wage_amt) AS per_day
								FROM hr.tbl_payroll
								WHERE	payroll_process_id = '$process->payroll_process_id'
								AND     employee_id        = '$employee_id'
                    GROUP BY employee_id) AS E ON A.employee_id	= E.employee_id
    				WHERE A.company_id		=	'$process->company_id'
					AND A.payroll_group_id	=	'$process->payroll_group_id'
					AND A.year_trans = '$process->year'
                    AND coalesce(A.month_trans,0) = '$process->month'
                    AND A.sss_total > 0")
        );
		
		foreach ($sss as $s) 
		{
			$dblEECont = 0;
            $dblERCont = 0;
            $dblEREC   = 0;
            $dblEE     = 0;
            $dblER     = 0;
            $dblEC     = 0;
			
			$basic = $this->init_Basic($salary_type, $s->basic_amt, $process->hrs_day, $process->days_mo);
			
			if (!empty($s->ee_cont) || !empty($s->ee_cont_bs) || !empty($s->ee_cont_sb)) {
                if ($s->ded_sss_basic_flag == 'N' && $s->ded_sss_sb_amt == 0) {
                    $dblEECont = $s->ee_cont;
                } elseif ($s->ded_sss_basic_flag == 'Y') {
                    $dblEECont = $s->ee_cont_bs;
                } elseif ($s->ded_sss_sb_amt > 0) {
                    $dblEECont = $s->ee_cont_sb;
                }
            }
			
			if (!empty($s->er_cont) || !empty($s->er_cont_bs) || !empty($s->er_cont_sb)) {
                if ($s->ded_sss_basic_flag == 'N' && $s->ded_sss_sb_amt == 0) {
                    $dblERCont = $s->er_cont;
                } elseif ($s->ded_sss_basic_flag == 'Y') {
                    $dblERCont = $s->er_cont_bs;
                } elseif ($s->ded_sss_sb_amt > 0) {
                    $dblERCont = $s->er_cont_sb;
                }
            }
			
			if (!empty($s->er_ec_cont) || !empty($s->er_ec_bs) || !empty($s->er_ec_sb)) {
                if ($s->ded_sss_basic_flag == 'N' && $s->ded_sss_sb_amt == 0) {
                    $dblEREC = $s->er_ec_cont;
                } elseif ($s->ded_sss_basic_flag == 'Y') {
                    $dblEREC = $s->er_ec_bs;
                } elseif ($s->ded_sss_sb_amt > 0) {
                    $dblEREC = $s->er_ec_sb;
                }
            }
			
			if ($s->ded_sss_basic_flag == 'N' && $s->ded_sss_sb_amt == '0') {
                $dblEE = !empty($s->ee) ? $s->ee : 0;
                $dblER = !empty($s->er) ? $s->er : 0;
                $dblEC = !empty($s->ec) ? $s->ec : 0;
            }
			
			if ($s->ded_sss_flag == 'Y') {
				
				if ($dblEECont > 0 || $dblERCont > 0 || $dblEREC > 0) {
                    $dblEECont = $dblEE > 0 ? $dblEECont - $dblEE : $dblEECont;
                    $dblERCont = $dblER > 0 ? $dblERCont - $dblER : $dblERCont;
                    $dblEREC   = $dblEC > 0 ? $dblEREC - $dblEC : $dblEREC;
                }
				
				if ($dblEECont > 0) {
					$msg_sss_ee = $this->add_payroll($process->payroll_process_id
								,$s->employee_id
								,$process->company_id
								,$s->business_unit_id
								,$s->tax_code
								,$s->tax_mode
								,$process->payroll_group_id
								,$s->payroll_mode
								,$process->payroll_period
								,$s->basic_amt
								,$s->ecola_amt
								,$s->allowance_amt
								,0
								,0
								,0
								,0
								,$process->year
								,$process->month
								,$process->date_from
								,$process->date_to
								,$process->date_payroll
								,0
								,0
								,'DB'
								,'2'
								,$dblEECont
								,$process->special_run_flag
								,null
								,0
								,$basic
								,$process->days_mo
								,null); // TODO: will change this if tbl_wage_order will be updated
				}
				
				if ($dblERCont > 0) {
					$msg_sss_er = $this->add_payroll($process->payroll_process_id
								,$s->employee_id
								,$process->company_id
								,$s->business_unit_id
								,$s->tax_code
								,$s->tax_mode
								,$process->payroll_group_id
								,$s->payroll_mode
								,$process->payroll_period
								,$s->basic_amt
								,$s->ecola_amt
								,$s->allowance_amt
								,0
								,0
								,0
								,0
								,$process->year
								,$process->month
								,$process->date_from
								,$process->date_to
								,$process->date_payroll
								,0
								,0
								,'EE'
								,'6'
								,$dblERCont
								,$process->special_run_flag
								,null
								,0
								,$basic
								,$process->days_mo
								,null); // TODO: will change this if tbl_wage_order will be updated
				}
				
				if ($dblEREC > 0) {
					$msg_sss_er = $this->add_payroll($process->payroll_process_id
								,$s->employee_id
								,$process->company_id
								,$s->business_unit_id
								,$s->tax_code
								,$s->tax_mode
								,$process->payroll_group_id
								,$s->payroll_mode
								,$process->payroll_period
								,$s->basic_amt
								,$s->ecola_amt
								,$s->allowance_amt
								,0
								,0
								,0
								,0
								,$process->year
								,$process->month
								,$process->date_from
								,$process->date_to
								,$process->date_payroll
								,0
								,0
								,'EE'
								,'7'
								,$dblEREC
								,$process->special_run_flag
								,null
								,0
								,$basic
								,$process->days_mo
								,null); // TODO: will change this if tbl_wage_order will be updated
				}
			}
		}
	}
	
	public function add_hdmf($process, $salary_type, $employee_id)
	{
		$hdmf = db::select(
            db::raw("select A.employee_id
						,(A.last_name || ', ' || A.first_name || ' ' || LEFT(A.middle_name, 1) || '.') AS emp_name
						,A.company_id
						,a.business_unit_id
						,A.tax_code
						,A.tax_mode
						,A.payroll_mode
						,A.salary_type
						,A.basic_amt
						,A.ecola_amt
						,A.allowance_amt
						,A.ded_sss_flag
						,A.ded_philhealth_flag
						,A.ded_pagibig_flag
						,a.ded_pagibig_basic_flag
						,A.pagibig_fix_amt
						,A.ded_pagibig_sb_amt
						,A.hdmf_total AS total
						,B.ee_cont
						,B.er_cont
						,B.ee_cont_percent
						,B.er_cont_percent
						,A.hdmf_ee AS ee
						,A.hdmf_er AS er
						,C.ee_cont AS ee_cont_bs
						,C.er_cont AS er_cont_bs
						,coalesce(D.ee_cont, 0) AS ee_cont_sb
						,coalesce(D.er_cont, 0) AS er_cont_sb
						,E.per_day
					FROM hr.view_govt_dedn A
					LEFT OUTER JOIN	hr.tbl_pagibig B
						ON	A.hdmf_total	>= B.range_from
						AND	A.hdmf_total	< B.range_to
						AND	A.company_id	= B.company_id
					LEFT OUTER JOIN	hr.tbl_pagibig C
						ON	A.basic_amt		>= C.range_from
						AND	A.basic_amt		< C.range_to
						AND	A.company_id	= C.company_id
					LEFT OUTER JOIN	hr.tbl_pagibig D
						ON	A.ded_pagibig_sb_amt	>= D.range_from
						AND	A.ded_pagibig_sb_amt	< D.range_to
						AND	A.company_id	= D.company_id
					INNER JOIN	(
								SELECT	employee_id, MAX(min_wage_amt) AS per_day
								FROM hr.tbl_payroll
								WHERE	payroll_process_id = '$process->payroll_process_id'
								AND     employee_id        = '$employee_id'
								GROUP BY employee_id
								) AS E
						ON	A.employee_id	= E.employee_id
						WHERE A.company_id	= '$process->company_id'
	                    AND A.payroll_group_id	= '$process->payroll_group_id'
	                    AND A.year_trans = '$process->year'
	                    AND coalesce(A.month_trans,0) = coalesce('$process->month',0)
						AND	A.hdmf_total > 0"
            )
        );
		
		foreach($hdmf as $hd)
		{
			$dblEECont    = 0;
            $dblERCont    = 0;
            $dblEE        = 0;
            $dblER        = 0;
            $dblEEPercent = 0;
            $dblERPercent = 0;
			
			$basic = $this->init_Basic($salary_type, $hd->basic_amt, $process->hrs_day, $process->days_mo);
			
			if(!empty($hd->ee_cont) || !empty($hd->ee_cont_bs) || !empty($hd->ee_cont_sb)){
                if($hd->ded_pagibig_basic_flag == 'N' && $hd->ded_pagibig_sb_amt == 0){
                    $dblEECont = $hd->ee_cont;
                }elseif ($hd->ded_pagibig_basic_flag == 'Y'){
                    $dblEECont = $hd->ee_cont_bs;
                }elseif ($hd->ded_pagibig_sb_amt > 0){
                    $dblEECont = $hd->ee_cont_sb;
                }
            }
			
			if(!empty($hd->er_cont) || !empty($hd->er_cont_bs) || !empty($hd->er_cont_sb)){
                if($hd->ded_pagibig_basic_flag == 'N' && $hd->ded_pagibig_sb_amt == 0){
                    $dblERCont = $hd->er_cont;
                }elseif ($hd->ded_pagibig_basic_flag == 'Y'){
                    $dblERCont = $hd->er_cont_bs;
                }elseif ($hd->ded_pagibig_sb_amt > 0){
                    $dblERCont = $hd->er_cont_sb;
                }
            }
			
			if($hd->ded_pagibig_basic_flag == 'N' && $hd->ded_pagibig_sb_amt == '0'){
                $dblEE = !empty($hd->ee) ? $ph->ee : 0;
                $dblER = !empty($hd->er) ? $ph->er : 0;
            }
			
            if(!empty($hd->ee_cont_percent)){
                $dblEEPercent = round($hd->ee_cont_percent * $hd->total, 2);
            }

            if(!empty($hd->er_cont_percent)){
                $dblERPercent = round($hd->er_cont_percent * $hd->total, 2);
            }

            $dblPagibigFix = !empty($hd->pagibig_fix_amt)? $hd->pagibig_fix_amt : 0;
			
			if ($hd->ded_pagibig_flag == 'Y'){
				
				if ($dblEECont > 0 || $dblERCont > 0 || $dblEEPercent > 0 || $dblERPercent > 0 || $dblPagibigFix > 0){
					
					$dblEECont = $dblEE > 0 ? $dblEECont - $dblEE : $dblEECont;
                    $dblERCont = $dblER > 0 ? $dblERCont - $dblER : $dblERCont;
					
					if ($dblPagibigFix > 0){
                        $dblEECont = $dblPagibigFix;
                    }

                    if ($dblEECont > $dblEEPercent){
                        $dblEECont = $dblEEPercent;
                        $dblERCont = $dblERPercent;
                    }
					
					if ($dblEECont > 0){
						$msg_hdmf_ee = $this->add_payroll($process->payroll_process_id
								,$hd->employee_id
								,$process->company_id
								,$hd->business_unit_id
								,$hd->tax_code
								,$hd->tax_mode
								,$process->payroll_group_id
								,$hd->payroll_mode
								,$process->payroll_period
								,$hd->basic_amt
								,$hd->ecola_amt
								,$hd->allowance_amt
								,0
								,0
								,0
								,0
								,$process->year
								,$process->month
								,$process->date_from
								,$process->date_to
								,$process->date_payroll
								,0
								,0
								,'DB'
								,'5'
								,$dblEECont
								,$process->special_run_flag
								,null
								,0
								,$basic
								,$process->days_mo
								,null); // TODO: will change this if tbl_wage_order will be updated
					}
					
					if ($dblERCont > 0){
						$msg_hdmf_er = $this->add_payroll($process->payroll_process_id
								,$hd->employee_id
								,$process->company_id
								,$hd->business_unit_id
								,$hd->tax_code
								,$hd->tax_mode
								,$process->payroll_group_id
								,$hd->payroll_mode
								,$process->payroll_period
								,$hd->basic_amt
								,$hd->ecola_amt
								,$hd->allowance_amt
								,0
								,0
								,0
								,0
								,$process->year
								,$process->month
								,$process->date_from
								,$process->date_to
								,$process->date_payroll
								,0
								,0
								,'EE'
								,'11'
								,$dblERCont
								,$process->special_run_flag
								,null
								,0
								,$basic
								,$process->days_mo
								,null); // TODO: will change this if tbl_wage_order will be updated);
					}
				}
			}
		}
	}
	
	public function add_philhealth($process, $salary_type, $employee_id)
	{
		$philhealth = db::select(
            db::raw("select	a.employee_id
					 ,			a.last_name || ', ' || a.first_name || ' ' || left(a.middle_name,1) || '.' as emp_name
					 ,			a.company_id
					 ,			a.business_unit_id
					 ,			a.tax_code
					 ,			a.tax_mode
					 ,			a.payroll_mode
					 ,			a.salary_type
					 ,			a.basic_amt
					 ,			a.ecola_amt
					 ,			a.allowance_amt
					 ,			a.ded_sss_flag
					 ,			a.ded_philhealth_flag
					 ,			a.ded_pagibig_flag
					 ,			a.ded_philhealth_basic_flag
					 ,			a.philhealth_dedn
					 ,			a.ded_philhealth_sb_amt
					 ,			a.philhealth_total as total
					 ,			b.ee_cont
					 ,			b.er_cont
					 ,			a.philhealth_ee as ee
					 ,			a.philhealth_er as er
					 ,			c.ee_cont AS ee_cont_bs
					 ,			c.er_cont AS er_cont_bs
					 ,			coalesce(D.ee_cont, 0) as ee_cont_sb
					 ,			coalesce(D.er_cont, 0) as er_cont_sb
					 ,			e.per_day
					 from		hr.view_govt_dedn as a
					 left join	hr.tbl_philhealth as b	on	a.philhealth_total	>=	b.range_from
					 									and	a.philhealth_total	<	b.range_to
					 									and	a.company_id		=	b.company_id
					 left join	hr.tbl_philhealth as c 	on	a.basic_amt			>=	c.range_from
					 									and	a.basic_amt			<	c.range_to
					 									and	a.company_id		=	c.company_id
					 left join	hr.tbl_philhealth as d 	on	a.philhealth_dedn	>=	d.range_from
					 									and	a.philhealth_dedn	<	d.range_to
					 									and	a.company_id		=	d.company_id
					 join		(select employee_id, max(min_wage_amt) as per_day from hr.tbl_payroll
					 				where payroll_process_id = '$process->payroll_process_id'
					 				and   employee_id        = '$employee_id'
					 				group by employee_id) as e
					 				on	a.employee_id		=	e.employee_id
					 where		a.company_id		=	'$process->company_id'
					 and		a.payroll_group_id	=	'$process->payroll_group_id'
					 AND 		A.year_trans = '$process->year'
                     AND 		coalesce(A.month_trans,0) = coalesce('$process->month',0)
					 and		a.philhealth_total	> 0"
            )
        );
		
		foreach($philhealth as $ph)
		{
			$dblEECont          = 0;
            $dblERCont          = 0;
            $dblEE              = 0;
            $dblER              = 0;
			
			$basic = $this->init_Basic($salary_type, $ph->basic_amt, $process->hrs_day, $process->days_mo);
			
			if(!empty($ph->ee_cont) || !empty($ph->ee_cont_bs) || !empty($ph->ee_cont_sb)){
                if ($ph->ded_philhealth_basic_flag == 'N' && $ph->philhealth_dedn == 0){
                    $dblEECont = $ph->ee_cont;
                } elseif ($ph->ded_philhealth_basic_flag == 'Y'){
                    $dblEECont = $ph->ee_cont_bs;
                } elseif ($ph->philhealth_dedn > 0){
                    $dblEECont = $ph->ee_cont_sb;
                }
            }
			
			if(!empty($ph->er_cont) || !empty($ph->er_cont_bs) || !empty($ph->er_cont_sb)){
                if($ph->ded_philhealth_basic_flag == 'N' && $ph->philhealth_dedn == 0){
                    $dblERCont = $ph->er_cont;
                } elseif($ph->ded_philhealth_basic_flag == 'Y'){
                    $dblERCont = $ph->er_cont_bs;
                } elseif($ph->philhealth_dedn > 0){
                    $dblERCont = $ph->er_cont_sb;
                }
            }
			
			if ($ph->ded_philhealth_basic_flag == 'N' && $ph->philhealth_dedn == '0'){
                $dblEE = !empty($ph->ee) ? $ph->ee : 0;
                $dblER = !empty($ph->er) ? $ph->er : 0;
            }
			
			if ($dblEECont > 0 || $dblERCont > 0){
                $dblEECont = $dblEE > 0 ? $dblEECont - $dblEE : $dblEECont;
                $dblERCont = $dblER > 0 ? $dblERCont - $dblER : $dblERCont;
            }
			
			if ($dblEECont > 0){
				$msg_ph_ee = $this->add_payroll($process->payroll_process_id
								,$ph->employee_id
								,$process->company_id
								,$ph->business_unit_id
								,$ph->tax_code
								,$ph->tax_mode
								,$process->payroll_group_id
								,$ph->payroll_mode
								,$process->payroll_period
								,$ph->basic_amt
								,$ph->ecola_amt
								,$ph->allowance_amt
								,0
								,0
								,0
								,0
								,$process->year
								,$process->month
								,$process->date_from
								,$process->date_to
								,$process->date_payroll
								,0
								,0
								,'DB'
								,'4'
								,$dblEECont
								,$process->special_run_flag
								,null
								,0
								,$basic
								,$process->days_mo
								,null); // TODO: will change this if tbl_wage_order will be updated
			}
			
			if ($dblERCont > 0){
				$msg_ph_er = $this->add_payroll($process->payroll_process_id
								,$ph->employee_id
								,$process->company_id
								,$ph->business_unit_id
								,$ph->tax_code
								,$ph->tax_mode
								,$process->payroll_group_id
								,$ph->payroll_mode
								,$process->payroll_period
								,$ph->basic_amt
								,$ph->ecola_amt
								,$ph->allowance_amt
								,0
								,0
								,0
								,0
								,$process->year
								,$process->month
								,$process->date_from
								,$process->date_to
								,$process->date_payroll
								,0
								,0
								,'EE'
								,'10'
								,$dblERCont
								,$process->special_run_flag
								,null
								,0
								,$basic
								,$process->days_mo
								,null); // TODO: will change this if tbl_wage_order will be updated
			}
		}
	}
	
	public function sel_tax($process, $param_rec, $employee_id)
	{
		
		$proc_rec = null;
		
		//sql4
		$sql_annual = 	"SELECT	a.employee_id AS emp_tran_id
						,		(a.last_name || ', ' || a.first_name || ' ' || LEFT(a.middle_name, 1) || '. (' || a.employee_number || ')') AS emp_name
						,		a.company_id
						,		h.business_unit_id
						,		b.tax_code
						,		d.tax_mode
						,		c.payroll_mode
						,		b.salary_type
						,		b.basic_amt
						,		b.ecola_amt
						,		b.allowance_amt
						,		f.income
						,		f.deduction
						,		f.with_tax
						,		(f.income - (f.deduction + e.exemption_amount)) AS total
						,		g.range_from
						,		g.percentage
						,		g.fix_amount
						,		e.exemption_amount
						,		i.daily_rate
						,		COALESCE(k.per_day_amt, 0) AS per_day  
						FROM			hr.tbl_employee			a
						INNER JOIN		hr.view_movement		b	ON	a.employee_id		= b.employee_id
						INNER JOIN		hr.tbl_payroll_profile	c	ON	a.payroll_group_id	= c.payroll_group_id
						INNER JOIN		hr.tbl_payroll_mode		d	ON	c.payroll_mode		= d.payroll_mode
																	AND	a.company_id		= d.company_id
						INNER JOIN		hr.tbl_tax_code			e	ON	b.tax_code			= e.tax_code
																	AND	b.company_id		= e.company_id
						LEFT OUTER JOIN	hr.view_annual_summary	f	ON	a.employee_id		= f.employee_id
																	AND	f.year_trans		= $process->year
						LEFT OUTER JOIN	hr.tbl_tax_annual		g	ON	((f.income - (f.deduction + e.exemption_amount)) > g.range_from
																	AND	(f.income - (f.deduction + e.exemption_amount)) <= g.range_to)
																	AND	a.company_id		= g.company_id
						INNER JOIN		(SELECT	employee_id
										,		SUM(entry_amt) AS amt
										,		business_unit_id
										FROM	hr.tbl_payroll
										WHERE	payroll_process_id	= '$process->payroll_process_id'
										AND     employee_id         = '$employee_id'
										GROUP BY employee_id
										,	business_unit_id)	h	ON	a.employee_id		= h.employee_id
																	AND	h.amt				> 0
						INNER JOIN	hr.view_daily_rate			i	ON	i.employee_id		= a.employee_id
																	AND	i.year				= f.year_trans
						INNER JOIN	hr.tbl_business_unit		j	ON	j.business_unit_id	= b.business_unit_id
																	AND	j.company_id		= a.company_id
						LEFT OUTER JOIN	hr.tbl_wage_order		k	ON	(i.daily_rate > 0::money AND i.daily_rate <= k.per_day_amt::money)
																	AND	k.company_id		= a.company_id
																	AND	k.region			= j.region
						WHERE	a.company_id		= '$process->company_id'
						AND		c.payroll_group_id	= '$process->payroll_group_id'
						AND		f.income			> 0";
		//sql5
		$sql_range1 =	"SELECT	a.employee_id
						,		(b.last_name || ', ' || b.first_name || ' ' || LEFT(b.middle_name, 1) || '. (' || b.employee_number || ')') AS emp_name
						,		a.company_id
						,		a.business_unit_id
						,		a.tax_code
						,		a.tax_mode
						,		a.payroll_mode
						,		h.salary_type
						,		a.basic_amt
						,		a.ecola_amt
						,		a.allowance_amt
						,		a.income
						,		a.deduction
						,		a.total
						,		c.range_from
						,		c.percentage
						,		c.fix_amount
						,		a.smw
						,		a.suplementary
						,		a.total2
						,		d.range_from AS range_from2
						,		d.percentage AS percentage2
						,		d.fix_amount AS fix_amount2
						,		f.tax_fix_amt
						,		f.add_tax_amt
						,		g.daily_rate
						,		COALESCE(j.per_day_amt, 0) AS per_day
						FROM		(SELECT	a.employee_id
									,		a.company_id
									,		a.business_unit_id
									,		a.tax_code
									,		a.tax_mode
									,		a.payroll_mode
									,		a.year_trans
									,		a.basic_amt
									,		a.ecola_amt
									,		a.allowance_amt
									,		SUM(CASE WHEN a.entry_type = 'CR' AND b.taxable_flag = 'Y' AND b.deminimis_flag = 'N' THEN a.entry_amt ELSE 0 END) AS income
									,		SUM(CASE WHEN a.entry_type = 'DB' AND b.tax_exempt_flag = 'Y' THEN a.entry_amt ELSE 0 END) AS deduction
									,		(SUM(CASE WHEN a.entry_type = 'CR' AND b.taxable_flag = 'Y' AND b.deminimis_flag = 'N' THEN a.entry_amt ELSE 0 END)
											- SUM(CASE WHEN a.entry_type = 'DB' AND b.tax_exempt_flag = 'Y' THEN a.entry_amt ELSE 0 END)) AS total
									,		SUM(CASE WHEN a.entry_type = 'CR' AND b.taxable_flag = 'Y' AND b.deminimis_flag = 'N' AND b.regular_flag = 'Y' THEN a.entry_amt ELSE 0 END) AS smw
									,		(SUM(CASE WHEN a.entry_type = 'CR' AND b.taxable_flag = 'Y' AND b.deminimis_flag = 'N' AND b.regular_flag = 'Y' THEN a.entry_amt ELSE 0 END)
											- SUM(CASE WHEN a.entry_type = 'DB' AND b.tax_exempt_flag = 'Y' THEN a.entry_amt ELSE 0 END)) AS total2
									,		SUM(CASE WHEN a.entry_type = 'CR' AND b.taxable_flag = 'Y' AND b.deminimis_flag = 'N' AND b.regular_flag = 'N' THEN a.entry_amt ELSE 0 END) AS suplementary
									FROM		hr.tbl_payroll			a
									INNER JOIN	hr.tbl_payroll_element	b	ON	a.payroll_element_id	= b.payroll_element_id 
																			AND	a.company_id			= b.company_id  
									WHERE		a.payroll_process_id	= '$process->payroll_process_id'
									AND         a.employee_id           = '$employee_id'
									GROUP BY	a.employee_id
									,			a.company_id
									,			a.business_unit_id
									,			a.tax_code
									,			a.tax_mode
									,			a.payroll_mode
									,			a.year_trans
									,			a.basic_amt
									,			a.ecola_amt
									,			a.allowance_amt)	a
						INNER JOIN		hr.tbl_employee				b	ON	a.employee_id		= b.employee_id
																		AND	b.active_flag		= 'Y'
						LEFT OUTER JOIN	hr.tbl_tax					c	ON	(a.total > c.range_from AND a.total <= c.range_to)
																		AND	a.tax_code			= c.tax_code
																		AND	a.tax_mode			= c.tax_mode
																		AND	b.company_id		= c.company_id
						LEFT OUTER JOIN	hr.tbl_tax 					d	ON	(a.total2 > d.range_from AND a.total2 <= d.range_to)
																		AND	a.tax_code			= d.tax_code
																		AND	a.tax_mode			= d.tax_mode
																		AND	b.company_id		= d.company_id
						INNER JOIN		(SELECT	employee_id
										,		SUM(entry_amt) AS amt
										FROM	hr.tbl_payroll
										WHERE	payroll_process_id = '$process->payroll_process_id'
										GROUP BY employee_id)		e	ON	a.employee_id		= e.employee_id
																		AND	e.amt				> 0
						INNER JOIN		hr.tbl_payroll_profile		f	ON	f.payroll_group_id	= b.payroll_group_id
						INNER JOIN		hr.view_daily_rate			g	ON	g.employee_id		= a.employee_id
																		AND	g.year				= a.year_trans
						INNER JOIN		hr.view_movement			h	ON	a.employee_id		= h.employee_id
						INNER JOIN		hr.tbl_business_unit		i	ON	i.business_unit_id	= a.business_unit_id
																		AND	i.company_id		= a.company_id
						LEFT OUTER JOIN	hr.tbl_wage_order			j	ON	(g.daily_rate > 0::money AND g.daily_rate <= j.per_day_amt::money)
																		AND	j.company_id		= a.company_id
																		AND	j.region			= i.region
						WHERE a.company_id = '$process->company_id'";
		//sql6
		$sql_range2 =	"SELECT	a.employee_id
						,		(b.last_name || ', ' || b.first_name || ' ' || LEFT(b.middle_name, 1) || '. (' || b.employee_number || ')') AS emp_name
						,		a.company_id
						,		b.business_unit_id
						,		a.tax_code
						,		a.tax_mode
						,		a.payroll_mode
						,		a.salary_type
						,		a.basic_amt
						,		a.ecola_amt
						,		a.allowance_amt
						,		a.income
						,		a.deduction
						,		a.total
						,		c.range_from
						,		c.percentage
						,		c.fix_amount
						,		a.smw
						,		a.suplementary
						,		a.total2
						,		d.range_from AS range_from2
						,		d.percentage AS percentage2
						,		d.fix_amount AS fix_amount2
						,		e.prev_tax
						,		g.tax_fix_amt
						,		g.add_tax_amt
						,		h.daily_rate
						,		COALESCE(j.per_day_amt, 0) AS per_day
						FROM		(SELECT	a.employee_id
									,		a.company_id
									,		c.tax_code
									,		b.tax_mode
									,		b.tax_mode_eom
									,		a.payroll_mode
									,		c.salary_type
									,		c.basic_amt
									,		c.ecola_amt
									,		c.allowance_amt
									,		SUM(CASE WHEN a.entry_type = 'CR' AND a.taxable_flag = 'Y' THEN a.entry_amt ELSE 0 END) AS income
									,		SUM(CASE WHEN a.entry_type = 'DB' AND a.tax_exempt_flag = 'Y' THEN a.entry_amt ELSE 0 END) AS deduction
									,		(SUM(CASE WHEN a.entry_type = 'CR' AND a.taxable_flag = 'Y' THEN a.entry_amt ELSE 0 END)
											- SUM(CASE WHEN a.entry_type = 'DB' AND a.tax_exempt_flag = 'Y' THEN a.entry_amt ELSE 0 END)) as total
									,		SUM(CASE WHEN a.entry_type = 'CR' AND a.taxable_flag = 'Y' AND a.deminimis_flag = 'N' AND a.regular_flag = 'Y' THEN a.entry_amt ELSE 0 END) AS smw
									,		(SUM(CASE WHEN a.entry_type = 'CR' AND a.taxable_flag = 'Y' AND a.deminimis_flag = 'N' AND a.regular_flag = 'Y' THEN a.entry_amt ELSE 0 END)
											- SUM(CASE WHEN a.entry_type = 'DB' AND a.tax_exempt_flag = 'Y' THEN a.entry_amt ELSE 0 END)) as total2
									,		SUM(CASE WHEN a.entry_type = 'CR' AND a.taxable_flag = 'Y' AND a.deminimis_flag = 'N' AND a.regular_flag = 'N' THEN a.entry_amt ELSE 0 END) AS suplementary
									,		d.payroll_group_id
									,		a.year_trans
									FROM		hr.view_payroll				a
									INNER JOIN	hr.tbl_payroll_mode			b	ON	a.tax_mode			= b.tax_mode 
																				AND	a.payroll_mode		= b.payroll_mode
																				AND	a.company_id		= b.company_id
									INNER JOIN	hr.view_movement			c	ON	a.employee_id		= c.employee_id
									INNER JOIN	hr.tbl_payroll_profile		d	ON	a.payroll_group_id	= d.payroll_group_id
									WHERE		a.payroll_group_id	= '$process->payroll_group_id'
									AND			a.year_trans		= $process->year
									AND			a.month_trans		= $process->month
									AND			a.company_id		= '$process->company_id'
									GROUP BY	a.employee_id
									,			a.company_id
									,			c.tax_code
									,			b.tax_mode
									,			b.tax_mode_eom
									,			a.payroll_mode
									,			c.salary_type
									,			c.basic_amt
									,			c.ecola_amt
									,			c.allowance_amt
									,			d.payroll_group_id
									,			a.year_trans
									)							a
						INNER JOIN		hr.tbl_employee			b	ON	a.employee_id		= b.employee_id
																	AND	b.active_flag		= 'Y'
						LEFT OUTER JOIN	hr.tbl_tax				c	ON	(a.total > c.range_from AND a.total <= c.range_to)
																	AND	a.tax_code			= c.tax_code
																	AND	a.tax_mode_eom		= c.tax_mode
																	AND	b.company_id		= c.company_id
						LEFT OUTER JOIN	hr.tbl_tax				d	ON	(a.total2 > d.range_from AND a.total2 <= d.range_to)
																	AND	a.tax_code			= d.tax_code
																	AND	a.tax_mode_eom		= d.tax_mode
																	AND	b.company_id		= d.company_id
						LEFT OUTER JOIN	(SELECT	employee_id
										,		SUM(entry_amt) AS prev_tax
										FROM	hr.view_payroll
										WHERE	payroll_group_id	= '$process->payroll_group_id'
										AND		year_trans			= $process->year
										AND		month_trans			= $process->month
										AND		payroll_element_id	= '12'
										GROUP BY employee_id
										)						e	ON	a.employee_id		= e.employee_id
						INNER JOIN		(SELECT	employee_id
										,		SUM(entry_amt) AS amt
										FROM	hr.tbl_payroll
										WHERE	payroll_process_id = '$process->payroll_process_id'
										AND     employee_id        = '$employee_id'
										GROUP BY employee_id
										)						f	ON	a.employee_id		= f.employee_id
																	AND	f.amt				> 0
						INNER JOIN		hr.tbl_payroll_profile	g	ON	g.payroll_group_id	= a.payroll_group_id
						INNER JOIN		hr.view_daily_rate		h	ON	h.employee_id		= a.employee_id
																	AND	h.year				= a.year_trans
						INNER JOIN		hr.tbl_business_unit	i	ON	i.business_unit_id	= b.business_unit_id
																	AND	i.company_id		= a.company_id
						LEFT OUTER JOIN	hr.tbl_wage_order		j	ON	(h.daily_rate > 0::money AND h.daily_rate <= j.per_day_amt::money)
																	AND	j.company_id		= a.company_id
																	AND	j.region			= i.region
						WHERE		a.company_id	= '$process->company_id'";
		
		
		//if(!empty($param_rec->annualize_income_mo)) {
		if(!empty($param_rec->annualize_income_mo) && ($param_rec->annualize_income_mo == substr(strtolower(date('F', mktime(0, 0, 0, $process->month, 10))),0,3))) {	// 20161010 updated by Melvin Militante
			
			$proc_rec = db::select(db::raw($sql_annual));
			
		} else {
			
			if($process->special_run_flag == 'Y') {
				
				// TODO: To determine what sql to execute
				
			} else {
				
				if($param_rec->tax_method == 1) {
					
					if(empty($process->tax_mode_eom)) {
						
						$proc_rec = db::select(db::raw($sql_range1));
						
					} else {
						
						$proc_rec = db::select(db::raw($sql_range2));
						
					}
					
				} elseif($param_rec->tax_method == 2) {
					
					// TODO: To determine what sql to execute (cumulative)
					
				} elseif($param_rec->tax_method == 3) {
					
					$proc_rec = db::select(db::raw($sql_annual));
					
				} elseif($param_rec->tax_method == 4) {
					
					// TODO: To determine what sql to execute (projected)
					
				}
				
			}
			
		}
		
		return ($proc_rec);
		
	}
	
	public function add_tax($process, $profile, $param_rec, $employee_id)
	{
		
		$sql_tax = $this->sel_tax($process, $param_rec, $employee_id);
		
		$dblWithTax = 0;
		$dblTotal = 0;
		$dblRange = 0;
		$dblPercentage = 0;
		$dblFix = 0;
		$dblPrevTax = 0;
		$dblTax = 0;
		
		$dblTaxFix = 0;
		$dblAddTax = 0;
		
		$dblTaxRefund = 0;
		
		$v_entry_type = null;
		$v_element_id = null;
		
		foreach($sql_tax as $tax) {
			
			$dblTaxFix = empty($tax->tax_fix_amt)? 0 : $tax->tax_fix_amt;
			$dblAddTax = empty($tax->add_tax_amt)? 0 : $tax->add_tax_amt;
			
			$basic = $this->init_Basic($tax->salary_type, $tax->basic_amt, $process->hrs_day, $process->days_mo);
			
			$dblTotal = $tax->total;
			$dblRange = !empty($tax->range_from)? $tax->range_from : 0;
			$dblPercentage = !empty($tax->percentage)? $tax->percentage : 0;
			$dblFix = !empty($tax->fix_amount)? $tax->fix_amount : 0;
			
			$dblTax = round((($dblTotal - $dblRange) * $dblPercentage) + $dblFix, 2);
			
			if ($process->special_run_flag != 'Y') {
				
				//if (!empty($param_rec->annualize_income_mo)) {
				if (!empty($param_rec->annualize_income_mo) && ($param_rec->annualize_income_mo == substr(strtolower(date('F', mktime(0, 0, 0, $process->month, 10))),0,3))) {
					
					$dblWithTax = !empty($tax->with_tax)? $tax->with_tax : 0;
					
				} else {
					
					if ($param_rec->tax_method == 1 || $param_rec->tax_method == 3 || $param_rec->tax_method == 4) {
						
						$dblWithTax = !empty($tax->with_tax)? $tax->with_tax : 0;
						
						if ($param_rec->tax_method == 4) {
							
							$dblPrevTax = !empty($tax->prev_tax)? $tax->prev_tax : 0;
							
						}
						
					} elseif ($param_rec->tax_method == 2) {
						
						// TODO: To determine process/computation on cumulative tax
						
					}
					
				}
				
			}
			
			// TODO: A first if is placed here regarding MWE
			
			if ($dblTotal > 0) {
				
				//if (!empty($param_rec->annualize_income_mo)) {
				if (!empty($param_rec->annualize_income_mo) && ($param_rec->annualize_income_mo == substr(strtolower(date('F', mktime(0, 0, 0, $process->month, 10))),0,3))) {
					
					$v_element_id = '12';
					$v_entry_type = 'DB';
					
					if ($dblTaxFix > 0 ) {
						$dblTax = $dblTaxFix + $dblAddTax;
					} else {
						
						if ($dblWithTax > $dblTax) {
							
							if ($process->auto_refund_flag == 'Y') {
								$dblTax = $dblWithTax - $dblTax;
								$dblTaxRefund = $dblWithTax - $dblTax;
								$v_element_id = '00044';		// TODO: Need to determine if this should stay as hard coded
								$v_entry_type = 'CR';
							} else {
								$dblTaxRefund = 0;
								$dblTax = 0;
							}
							
						} elseif ($dblWithTax < $dblTax) {
							$dblTax = $dblTax - $dblWithTax;
						}
						
					}
					
					if ($dblTaxFix > 0) {
						$msg_tax = $this->add_payroll($process->payroll_process_id
								,$tax->employee_id
								,$process->company_id
								,$tax->business_unit_id
								,$tax->tax_code
								,$tax->tax_mode
								,$process->payroll_group_id
								,$tax->payroll_mode
								,$process->payroll_period
								,$tax->basic_amt
								,$tax->ecola_amt
								,$tax->allowance_amt
								,0
								,0
								,0
								,0
								,$process->year
								,$process->month
								,$process->date_from
								,$process->date_to
								,$process->date_payroll
								,0
								,0
								,'DB'
								,'12'
								,$dblTax
								,$process->special_run_flag
								,null
								,0
								,$basic
								,$process->days_mo
								,null); // TODO: will change this if tbl_wage_order will be updated
					} else {
						
						if ($v_entry_type == 'DB') {
							$msg_tax = $this->add_payroll($process->payroll_process_id
									,$tax->employee_id
									,$process->company_id
									,$tax->business_unit_id
									,$tax->tax_code
									,$tax->tax_mode
									,$process->payroll_group_id
									,$tax->payroll_mode
									,$process->payroll_period
									,$tax->basic_amt
									,$tax->ecola_amt
									,$tax->allowance_amt
									,0
									,0
									,0
									,0
									,$process->year
									,$process->month
									,$process->date_from
									,$process->date_to
									,$process->date_payroll
									,0
									,0
									,$v_entry_type
									,$v_element_id
									,$dblTax
									,$process->special_run_flag
									,null
									,0
									,$basic
									,$process->days_mo
									,null); // TODO: will change this if tbl_wage_order will be updated
						} elseif ($v_entry_type == 'CR') {
							
							if ($process->auto_refund_flag == 'Y') {
								$msg_tax = $this->add_payroll($process->payroll_process_id
									,$tax->employee_id
									,$process->company_id
									,$tax->business_unit_id
									,$tax->tax_code
									,$tax->tax_mode
									,$process->payroll_group_id
									,$tax->payroll_mode
									,$process->payroll_period
									,$tax->basic_amt
									,$tax->ecola_amt
									,$tax->allowance_amt
									,0
									,0
									,0
									,0
									,$process->year
									,$process->month
									,$process->date_from
									,$process->date_to
									,$process->date_payroll
									,0
									,0
									,$v_entry_type
									,$v_element_id
									,$dblTax
									,$process->special_run_flag
									,null
									,0
									,$basic
									,$process->days_mo
									,null); // TODO: will change this if tbl_wage_order will be updated								
							} else {
								// TODO: Check the source code of Messages.mtdTaxRefund_New
							}
						}
					}
				} else {
					
					if ($dblTaxFix == 0) {
						if ($dblPrevTax > 0) {
							$dblTax = round($dblTax - $dblPrevTax, 2) + $dblAddTax;
						}
					} elseif ($dblTaxFix > 0) {
						$dblTax = $dblTaxFix + $dblAddTax;
					} else {
						$dblTax = 0;
					}
					
					$dblTax = ($dblTax < 0)? 0 : $dblTax;
					
					$msg_tax = $this->add_payroll($process->payroll_process_id
							,$tax->employee_id
							,$process->company_id
							,$tax->business_unit_id
							,$tax->tax_code
							,$tax->tax_mode
							,$process->payroll_group_id
							,$tax->payroll_mode
							,$process->payroll_period
							,$tax->basic_amt
							,$tax->ecola_amt
							,$tax->allowance_amt
							,0
							,0
							,0
							,0
							,$process->year
							,$process->month
							,$process->date_from
							,$process->date_to
							,$process->date_payroll
							,0
							,0
							,'DB'
							,'12'
							,$dblTax
							,$process->special_run_flag
							,null
							,0
							,$basic
							,$process->days_mo
							,null); // TODO: will change this if tbl_wage_order will be updated								
				}
			} elseif ($dblTotal == 0) {
				$msg_tax = $this->add_payroll($process->payroll_process_id
						,$tax->employee_id
						,$process->company_id
						,$tax->business_unit_id
						,$tax->tax_code
						,$tax->tax_mode
						,$process->payroll_group_id
						,$tax->payroll_mode
						,$process->payroll_period
						,$tax->basic_amt
						,$tax->ecola_amt
						,$tax->allowance_amt
						,0
						,0
						,0
						,0
						,$process->year
						,$process->month
						,$process->date_from
						,$process->date_to
						,$process->date_payroll
						,0
						,0
						,'DB'
						,'12'
						,$dblTax
						,$process->special_run_flag
						,null
						,0
						,$basic
						,$process->days_mo
						,null); // TODO: will change this if tbl_wage_order will be updated								
			}
			
			$dblTax = 0;
		}
	}
	
	public function updateStatusPayProc($payroll_process_id, $status)
	{
		db::table('hr.tbl_payroll_process')
			->where('payroll_process_id',$payroll_process_id)
			->update(['status' => $status]);
	}
}
