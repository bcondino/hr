<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_dependents_model extends Model
{
	protected $table = 'tbl_dependents';
	protected $primaryKey = 'dependent_id';
	protected $guarded = ['dependent_id'];
    //
}