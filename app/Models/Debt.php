<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $table = 'nrhosp_acc_debt';
    protected $primaryKey = 'debt_id';
    public $incrementing = false; //ไม่ใช้ options auto increment
    public $timestamps = false; //ไม่ใช้ field updated_at และ created_at
    
    public function debttype()
  	{
      	return $this->belongsTo('App\Models\DebtType', 'debt_type_id', 'debt_type_id');
  	}
}
