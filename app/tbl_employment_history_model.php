<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_employment_history_model extends Model
{
	protected $table = 'tbl_employment_history';
	protected $primaryKey = 'emp_hist_id';
	protected $guarded = ['emp_hist_id'];
}