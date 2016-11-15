<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_payroll_profile_model extends Model
{
    //
    protected $table = 'tbl_payroll_profile';
    protected $primaryKey = 'payroll_profile_id';
    protected $guarded = ['payroll_profile_id'];
}
