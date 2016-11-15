<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_payroll_mode_model extends Model
{
    //
    protected $table = 'tbl_payroll_mode';
    protected $primaryKey = 'payroll_mode_id';
    protected $guarded = ['payroll_mode_id'];
}
