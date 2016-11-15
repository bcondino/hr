<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_salary_grade_model extends Model
{
    protected $primaryKey = 'grade_id';    
    protected $table = 'tbl_salary_grade';
    protected $guarded = ['grade_id'];
}
