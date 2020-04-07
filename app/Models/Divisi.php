<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{

    protected $table = 'divisions';
    protected $primaryKey = 'id';
    protected $fillable = array('name');
    public $timestamps = true; 
	
    public function users()
    {
        return $this->belongsTo('App\Models\User','id_division');
    }
	
	public function listUsers()
    {
        return $this->hasMany('App\Models\User','id_division');
    }
}
