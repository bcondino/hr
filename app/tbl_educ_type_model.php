<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_educ_type_model extends Model
{
    //
    protected $table = 'tbl_educ_type';
    protected $primaryKey = 'educ_type_id';
    protected $guarded = ['educ_type_id'];
}
