<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_wage_order_model extends Model
{
    //
    protected $table = 'tbl_wage_order';
    protected $primaryKey = 'wage_order_id';
    protected $guarded = ['wage_order_id'];
}
