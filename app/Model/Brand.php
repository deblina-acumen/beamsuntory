<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table='brand';
    public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
}
