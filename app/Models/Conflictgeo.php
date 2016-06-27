<?php 
namespace App\Models;

 use Illuminate\Database\Eloquent\Model;

 class Conflictgeo extends Model{
 	protected $table = 'conflict_geo';

 	public function conflict()
    {
        return $this->belongsTo('App\Models\Conflict', 'id', 'id');
    }


 }
