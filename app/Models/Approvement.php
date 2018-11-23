<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approvement extends Model
{
    protected $table = 'nrhosp_acc_app';
    protected $primaryKey = 'app_id';
    public $incrementing = false; //ไม่ใช้ options auto increment
    public $timestamps = false; //ไม่ใช้ field updated_at และ created_at
    
    public function app_detail()
  	{
      	return $this->hasMany('App\Models\ApprovementDetail', 'app_id', 'app_id');
  	}

  	public function payment_detail()
  	{
      	return $this->hasMany('App\Models\PaymentDetail', 'app_id', 'app_id');
  	}
}
