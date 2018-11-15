<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebtType extends Model
{
    protected $table = 'nrhosp_acc_debt_type';

    public function debt()
    {
        return $this->hasMany('App\Models\Debt', 'debt_type_id', 'debt_type_id');
    }
}
