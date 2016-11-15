<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_tax_annual_model extends Model
{
    //
    protected $table = 'tbl_tax_annual';
    protected $primaryKey = 'tax_annual_id';
    protected $guarded = ['tax_annual_id'];
}
