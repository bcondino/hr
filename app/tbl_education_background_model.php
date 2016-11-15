<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_education_background_model extends Model
{
	protected $table = 'tbl_education_background';
	protected $primaryKey = 'educ_back_id';
	protected $guarded = ['educ_back_id'];
    //
}