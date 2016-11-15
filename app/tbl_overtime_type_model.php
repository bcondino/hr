<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_overtime_type_model extends Model
{
    //
    protected $table = 'tbl_overtime_type';
    protected $primaryKey = 'overtime_type_id';
    protected $guarded = ['overtime_type_id'];
}
