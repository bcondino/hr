<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_tax_code_model extends Model
{
    //
    protected $table = 'tbl_tax_code';
    protected $primaryKey = 'tax_code_id';
    protected $guarded = ['tax_code_id'];
}
