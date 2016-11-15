<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_position_model extends Model
{
    protected $primaryKey = 'position_id';    
    protected $table = 'tbl_position';
    protected $guarded = ['position_id'];
}
