<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_company_model extends Model
{
    protected $primaryKey = 'company_id';    
    protected $table = 'tbl_company';

    protected $guarded = [
        'company_id',
    ];

	public function businessUnit(){
    	return $this->hasMany('App\tbl_business_unit_model','company_id');
    }

    public function userCompany(){
    	return $this->hasMany('App\tbl_user_company_model','company_id');
    }

}
