<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_payroll_process_model extends Model
{
    //
    protected $table = 'tbl_payroll_process';
    protected $primaryKey = 'payroll_process_id';
    protected $guarded = ['payroll_process_id'];
}
