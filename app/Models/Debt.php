<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $table = 'nrhosp_acc_debt';

    public function debttype()
  	{
      	return $this->belongsTo('App\Models\DebtType', 'debt_type_id', 'debt_type_id');
  	}
}
