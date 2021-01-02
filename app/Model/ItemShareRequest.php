<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItemShareRequest extends Model
{
	  protected $table='item_share_request';
      protected $fillable = [];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}