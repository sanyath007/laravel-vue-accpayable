<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $table = 'stock_budget';
    protected $primaryKey = 'budget_id';
    public $incrementing = false; //ไม่ใช้ options auto increment
    public $timestamps = false; //ไม่ใช้ field updated_at และ created_at
    
    public function payment()
  	{
      	return $this->hasMany('App\Models\Payment', 'budget_id', 'budget_id');
  	}

  	public function approve()
  	{
      	return $this->hasMany('App\Models\Approvement', 'budget_id', 'budget_id');
  	}
}
