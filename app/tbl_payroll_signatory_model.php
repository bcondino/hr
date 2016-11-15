<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_payroll_signatory_model extends Model
{
    //
    protected $table = 'tbl_signatory';
    protected $primaryKey = 'signatory_id';
    protected $guarded = ['signatory_id'];
}
