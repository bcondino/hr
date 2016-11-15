<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_payroll_disbursement_model extends Model
{
    //
    protected $table = 'tbl_payroll_disbursement';
    protected $primaryKey = 'pay_disb_id';
    protected $guarded = ['pay_disb_id'];
}
