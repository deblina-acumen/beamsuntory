<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	  protected $table='country';
      protected $fillable = [];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}