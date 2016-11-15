<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_payroll_period_model extends Model
{
    //
    protected $table = 'tbl_payroll_period';
    protected $primaryKey = 'payroll_period_id';
    protected $guarded = ['payroll_period_id'];
}
