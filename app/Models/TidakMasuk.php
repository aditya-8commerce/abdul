<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TidakMasuk extends Model
{

    protected $table = 'absent';
    protected $primaryKey = 'id';
    protected $fillable = array('id_user','date_start','date_finish','reason','description','total_days','approve_by_leader','approve_status_by_leader','approve_by_director','approve_status_by_director');
    public $timestamps = true; 
	
    public function users()
    {
        return $this->belongsTo('App\Models\User','id_user');
    }
	
	
    public function user()
    {
        return $this->hasOne('App\Models\User','id','id_user');
    }
}
