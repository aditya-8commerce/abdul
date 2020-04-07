<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleEmergency extends Model
{

    protected $table = 'schedule_emergency';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'customer','id_user','subject','id_product','serial_number','running_hours',
        'issue','action','recommendation','line','year','date','file'
    );
    public $timestamps = true; 
	
   
	public function user()
    {
        return $this->hasOne('App\Models\User','id','id_user');
    }

    public function produk()
    {
        return $this->hasOne('App\Models\Produk','id','id_product');
    }

    public function schedule()
    {
        return $this->belongsTo('App\Models\Schedule','id','id_emergency');
    }

    public function vSchedule()
    {
        return $this->belongsTo('App\Models\VSchedule','id','id_emergency');
    }
}
