<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	  protected $table='item';
      protected $fillable = ['name','product_type','description','brand_id','sub_brand_id','category_id','supplier_id','image','price_currency','regular_price','retail_price','sku','status','low_stock_level','batch_no','weight','length','width','height','self_life','expire_date','is_active','is_deleted','created_at','created_by','updated_at','updated_by'];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}