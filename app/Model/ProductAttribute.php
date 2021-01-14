<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
	  protected $table='product_attribute';
      protected $fillable = ['name','value','is_active','is_deleted','created_at','created_by','updated_at','updated_by'];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}