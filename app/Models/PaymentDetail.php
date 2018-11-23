<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    protected $table = 'nrhosp_acc_payment_detail';
    protected $primaryKey = 'payment_detail_id';
    public $incrementing = false; //ไม่ใช้ options auto increment
    public $timestamps = false; //ไม่ใช้ field updated_at และ created_at
    
    public function debt()
  	{
      	return $this->belongsTo('App\Models\Debt', 'debt_id', 'debt_id');
  	}

  	public function payment()
  	{
      	return $this->belongsTo('App\Models\Payment', 'payment_id', 'payment_id');
  	}

  	public function approve()
  	{
      	return $this->belongsTo('App\Models\Approve', 'app_id', 'app_id');
  	}
}
