<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class view_govt_dedn_model extends Model
{
    //
    protected $table = 'view_govt_dedn';
    protected $primaryKey = 'employee_id';
    protected $guarded = ['employee_id'];
}
