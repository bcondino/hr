<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tbl_classification_model extends Model
{
    protected $table = 'tbl_classification';
    protected $primaryKey = 'class_id';    
    protected $guarded = ['class_id'];
}
