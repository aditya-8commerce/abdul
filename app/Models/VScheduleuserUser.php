<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VScheduleuserUser extends Model
{

    protected $table = 'vw_scheduleuser_user';
    protected $fillable = array('id_schedule','id_user',
        'name','indentity_number');
    public $timestamps = false; 
	
    
}
