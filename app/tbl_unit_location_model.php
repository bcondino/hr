<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_unit_location_model extends Model
{
    protected $primaryKey = 'location_id';    
    protected $table = 'tbl_unit_location';
    protected $guarded = ['location_id'];
}
