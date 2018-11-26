<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebtType extends Model
{
    protected $table = 'nrhosp_acc_debt_type';
    protected $primaryKey = 'debt_type_id';
    public $incrementing = false; //ไม่ใช้ options auto increment
    // public $timestamps = false; //ไม่ใช้ field updated_at และ created_at

    public function debt()
    {
        return $this->hasMany('App\Models\Debt', 'debt_type_id', 'debt_type_id');
    }
}
