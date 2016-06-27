<?php
 
 namespace App\Models;

 use Illuminate\Database\Eloquent\Model;

 class Conflict extends Model{
 	protected $table = 'conflict';

 	    public function conflictgeo()
    {
        return $this->hasMany('App\Models\Conflictgeo', 'id', 'ID');
    }

 }

