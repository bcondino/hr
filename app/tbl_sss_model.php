<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_sss_model extends Model
{
    //
    protected $table = 'tbl_sss';
    protected $primaryKey ='sss_id';
    protected $guarded = ['sss_id'];
}
