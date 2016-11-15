<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_tax_mode_model extends Model
{
    //
    protected $table = 'tbl_tax_mode';
    protected $primaryKey = 'tax_mode_id';
    protected $guarded = ['tax_mode_id'];
}
