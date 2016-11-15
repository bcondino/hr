<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_philhealth_model extends Model
{
    //
    protected $table = 'tbl_philhealth';
    protected $primaryKey = 'philhealth_id';
    protected $guarded = ['philhealth_id'];
}
