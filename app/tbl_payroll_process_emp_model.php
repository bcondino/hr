<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_payroll_process_emp_model extends Model
{
    //
    protected $table = 'tbl_payroll_process_emp';
    protected $primaryKey = 'payroll_process_emp_id';
    public $timestamps = false;
    protected $fillable =  [
    	'payroll_process_id'
    	,'employee_id'
    ];
}
