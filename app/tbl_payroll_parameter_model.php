<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_payroll_parameter_model extends Model
{
    //
    protected $table = 'tbl_payroll_parameter';
    protected $primaryKey = 'payroll_parameter_id';
    protected $guarded = ['payroll_parameter_id'];
}
