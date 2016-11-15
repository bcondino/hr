<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_business_unit_model extends Model
{
    protected $table = 'tbl_business_unit';
    protected $primaryKey = 'business_unit_id';
    protected $guarded = ['business_unit_id'];


public static function formCategories() {
    return array_merge([0 => 'Please select...'], static::$category);
}
    public function company(){
    	return $this->belongsTo('App\tbl_company_model','company_id');
    }
}
