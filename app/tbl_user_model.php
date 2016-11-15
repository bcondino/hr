<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class tbl_user_model extends Model
{
    protected $table = 'tbl_user';
    protected $primaryKey = 'user_id';
    protected $guarded = ['user_id'];

    public function getSelect($col_form, $oper_form, $para_form) {

    	 return DB::table('tbl_user')->orderBy('last_name','ASC')
    	 							 ->where($col_form, $oper_form, $para_form)
    	 							 ->get();
    }
}
