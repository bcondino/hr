<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class tbl_user_company_model extends Model
{
    //
    protected $table = 'tbl_user_company';
    protected $primaryKey = 'user_comp_id';

    protected $guarded = [
        'user_comp_id',
    ];

    public function company(){
    	return $this->belongsTo('App\tbl_company_model', 'company_id');
    }
}
