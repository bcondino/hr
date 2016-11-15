<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_tax_model extends Model
{
    //
    protected $table = "tbl_tax";
    protected $primaryKey = 'tax_id';
    protected $guarded = ['tax_id'];
}
