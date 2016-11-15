<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_payroll_group_model extends Model
{
    //
    protected $table = 'tbl_payroll_group';
    protected $primaryKey = 'payroll_group_id';
    protected $guarded = ['payroll_group_id'];
}
