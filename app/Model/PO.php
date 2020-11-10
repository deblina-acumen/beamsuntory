<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PO extends Model
{
	  protected $table='purchase_order';
      protected $fillable = [];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}