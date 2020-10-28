<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
	  protected $table='store';
      protected $fillable = [];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}