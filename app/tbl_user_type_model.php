<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_user_type_model extends Model
{
    //
    protected $table = 'tbl_user_type';
    protected $primaryKey = 'user_type_id';

    protected $guarded = [
        'user_type_id',
    ];
}
