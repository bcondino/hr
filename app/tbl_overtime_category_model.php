<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_overtime_category_model extends Model
{
    //
    protected $table = 'tbl_overtime_category';
    protected $primaryKey = 'overtime_category_id';
    protected $guarded = ['overtime_category_id'];
}
