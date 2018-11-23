<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'nrhosp_acc_payment';
    protected $primaryKey = 'payment_id';
    public $incrementing = false; //ไม่ใช้ options auto increment
    public $timestamps = false; //ไม่ใช้ field updated_at และ created_at
    
    public function payment_detail()
  	{
      	return $this->hasMany('App\Models\PaymentDetail', 'payment_id', 'payment_id');
  	}
}
