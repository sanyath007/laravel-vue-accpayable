<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierPrefix extends Model
{
    protected $table = 'nrhosp_acc_sup_prename';
    protected $primaryKey = 'prename_id';
    public $incrementing = false; //ไม่ใช้ options auto increment
    public $timestamps = false; //ไม่ใช้ field updated_at และ created_at

    public function creditor()
    {
        return $this->hasMany('App\Models\Creditor', 'prename_id', 'prename_id');
    }
}
