<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_movement_model extends Model
{
    //
    protected $table = 'tbl_movement';
    protected $primaryKey = 'movement_id';
    protected $guarded = ['movement_id'];
}
