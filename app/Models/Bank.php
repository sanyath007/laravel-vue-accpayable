<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'nrhosp_acc_bank';
    protected $primaryKey = 'bank_id';
    public $incrementing = false; //ไม่ใช้ options auto increment
    public $timestamps = false; //ไม่ใช้ field updated_at และ created_at
    
    public function bankAccount()
  	{
      	return $this->hasBelongs('App\Models\BankAccount', 'bank_id', 'bank_id');
  	}

  	public function bankBranch()
  	{
      	return $this->hasMany('App\Models\BankBranch', 'bank_id', 'bank_id');
  	}
}
