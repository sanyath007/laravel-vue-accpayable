<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $table = 'nrhosp_acc_debt';
    
    protected $primaryKey = 'debt_id';

    public $incrementing = false; //ไม่ใช้ options auto increment

    public $timestamps = false; //ไม่ใช้ field updated_at และ created_at

    protected $fillable = ['debt_status'];
    
    public function debttype()
  	{
      	return $this->belongsTo('App\Models\DebtType', 'debt_type_id', 'debt_type_id');
  	}

  	public function app_detail()
  	{
      	return $this->hasMany('App\Models\ApprovementDetail', 'debt_id', 'debt_id');
  	}

  	public function payment_detail()
  	{
      	return $this->hasMany('App\Models\PaymentDetail', 'debt_id', 'debt_id');
  	}
}
