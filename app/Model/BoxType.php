<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BoxType extends Model
{
	  protected $table='box_type';
      protected $fillable = [];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}