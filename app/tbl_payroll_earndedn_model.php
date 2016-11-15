<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_payroll_earndedn_model extends Model
{
    //
    protected $table = 'tbl_payroll_earndedn';
    protected $primaryKey = 'payroll_earndedn_id';
    protected $guarded = ['payroll_earndedn_id'];
}
