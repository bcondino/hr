<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_employee_model extends Model
{
	protected $table = 'tbl_employee';
	protected $primaryKey = 'employee_id';
	protected $guarded = ['employee_id'];
    //
}
