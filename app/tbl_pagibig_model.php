<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_pagibig_model extends Model
{
    //
    protected $table = 'tbl_pagibig';
    protected $primaryKey = 'pagibig_id';
    protected $guarded = ['pagibig_id'];
}
