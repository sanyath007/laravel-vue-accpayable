<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creditor extends Model
{
    protected $table = 'stock_supplier';
    protected $primaryKey = 'supplier_id';
    public $incrementing = false; //ไม่ใช้ options auto increment
    // public $timestamps = false; //ไม่ใช้ field updated_at และ created_at

    public function prefix()
    {
        return $this->belongsTo('App\Models\SupplierPrefix', 'prename_id', 'prename_id');
    }
}
