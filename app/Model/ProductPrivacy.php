<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductPrivacy extends Model
{
	  protected $table='item_privacy';
      protected $fillable = [];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}