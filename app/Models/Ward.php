<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $connection = 'person';

    protected $table = 'ward';
  
    public function user()
    {
        return $this->hasMany('App\Models\User', 'ward_id', 'office_id');
    }
}
