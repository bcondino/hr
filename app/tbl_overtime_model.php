<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_overtime_model extends Model
{
    //
    protected $table = 'tbl_overtime';
    protected $primaryKey = 'overtime_id';
    protected $guarded = ['overtime_id'];
}
