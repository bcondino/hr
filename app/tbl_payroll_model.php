<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_payroll_model extends Model
{
    protected $table = 'tbl_payroll';
    protected $primaryKey = 'payroll_id';
    protected $fillable =  [
    	   'payroll_id'
	  ,'payroll_process_id'
	  ,'counter'
	  ,'employee_id'
	  ,'company_id'
	  ,'business_unit_id'
	  ,'tax_code'
	  ,'tax_mode'
	  ,'payroll_group_id'
	  ,'payroll_mode'
	  ,'payroll_period_id'
	  ,'basic_amt'
	  ,'ecola_amt'
	  ,'allowance_amt'
	  ,'hrs_work'
	  ,'hrs_late'
	  ,'hrs_undertime'
	  ,'hrs_absent'
	  ,'year_trans'
	  ,'month_trans'
	  ,'date_from'
	  ,'date_to'
	  ,'date_payroll'
	  ,'sequence_no'
	  ,'group_sequence_no'
	  ,'entry_type'
	  ,'payroll_element_id'
	  ,'entry_amt'
	  ,'special_run_flag'
	  ,'tran_ref_id'
	  ,'payment_ctr'
	  ,'daily_rate_amt'
	  ,'days_mo'
	  ,'min_wage_amt'
	  ,'created_at'
	  ,'created_by'
	  ,'updated_at'
	  ,'updated_by'
	  ,'active_flag'
    ];
}
