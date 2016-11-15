<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_employee_type_model extends Model
{
	protected $primaryKey = 'emp_type_id';    
    protected $table = 'tbl_employee_type';
    protected $guarded = ['emp_type_id'];
}